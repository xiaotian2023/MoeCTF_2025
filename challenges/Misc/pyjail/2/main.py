def chall():
    user_input = input("Give me your code: ")
    forbidden_keywords = ['import', 'eval', 'exec', 'open', 'file']
    for keyword in forbidden_keywords:
        if keyword in user_input:
            print(f"Forbidden keyword detected: {keyword}")
            return
    forbidden_chars = ['.', '_', '[', ']', "'", '"']
    for char in forbidden_chars:
        if char in user_input:
            print(f"Forbidden character detected: {char}")
            return
    result = eval(user_input)
def handle():
    import os
    os.setuid(65534)
    del os
    import random
    import string
    print(
        "HTTP/1.1 302 Found\r\nLocation: https://ctf.xidian.edu.cn/wiki/13\r\nContent-Length: 0\r\n\r\n===HTTP REQUEST BLOCK===\x00\033c"
    )
    try:
        count = 0
        while True:
            random_str = ''.join(random.choices(string.ascii_uppercase + string.digits, k=8))
            if (
                input(
                    f"Please enter the reverse of '{random_str}' to continue: "
                )
                .strip()
                .upper()
                != random_str[::-1]
            ):
                count += 1
                print("Error! Please try again.")
                if count > 5:
                    print("Too many tries, blocked")
                    break
                continue
            count = 0
            try:
                chall() # type: ignore # noqa: F821
            except Exception as e:
                print(f"Error: {e}") # 这里会捕获 chall() 抛出的异常，有回显
    except Exception as e:
        print(
            f"\033c ========== Unhandled Error! ==========\n  We cannot recover from error: {e}\nChild process exited. Please reconnect or ask administrators for help if error persist"
        )
def daemon_main():
    import os
    import socket
    import subprocess
    print("[Info] Server starting")
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    pwd = os.path.dirname(__file__)
    script = open(__file__, "rb").read()
    self_fd = os.memfd_create("main")
    os.write(self_fd, script)
    os.lseek(self_fd, 0, os.SEEK_SET)
    os.chmod(self_fd, 0o400)
    try:
        sock.bind(("0.0.0.0", 9999))
        sock.listen(1)
        while True:
            try:
                conn, addr = sock.accept()
                print(f"[Info] Connected with {addr}")
                fd = conn.fileno()
                subprocess.Popen(
                    [
                        "python",
                        "/proc/self/fd/{}".format(self_fd),
                        "fork",
                    ],
                    stdin=fd,
                    stdout=fd,
                    stderr=fd,
                    pass_fds=[self_fd],
                    cwd=pwd,
                    env=os.environ,
                )
            except Exception as e:
                print(f"[Error] {e}")
    except KeyboardInterrupt:
        print("[Info] Server stopped")
    finally:
        sock.close()
        print("[Info] Server closed")
if __name__ == "__main__":
    import sys
    if len(sys.argv) == 2 and sys.argv[1] == "fork":
        del sys
        handle()
    else:
        daemon_main()
