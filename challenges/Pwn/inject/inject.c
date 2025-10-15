#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>

static void menu() {
    printf("1. List processes\n2. Check disk usage\n3. Check network "
           "activity\n4. Test connectivity\n5. Exit\nYour choice: ");
}

int check(const char *restrict input) {
    return (strpbrk(input, ";&|><$(){}[]'\"`\\!~*") == NULL);
}

void execute(const char *restrict cmd) {
    printf("Executing command: %s\n", cmd);
    if (system(cmd) != 0) {
        puts("Something went wrong.\n");
        return;
    }
    puts("Done.");
}

void ping_host() {
    char cmd[32];
    char host[16] = {0};

    printf("Enter host to ping: ");
    if (read(STDIN_FILENO, host, 15) <= 0) {
        exit(EXIT_FAILURE);
    }
    if (host[strlen(host) - 1] == '\n') {
        host[strlen(host) - 1] = '\0';
    }
    if (!check(host)) {
        puts("Invalid hostname or IP!");
        return;
    }

    snprintf(cmd, sizeof(cmd), "ping %s -c 4", host);

    execute(cmd);
}

int main(void) {
    setbuf(stdout, NULL);
    setbuf(stdin, NULL);
    puts("Welcome to server maintainance system.");

    unsigned int choice;
    for (;;) {
        menu();
        if (scanf("%u", &choice) < 0) {
            exit(EXIT_FAILURE);
        }
        getchar();

        switch (choice) {
        case 1:
            execute("ps aux");
            break;
        case 2:
            execute("df -h");
            break;
        case 3:
            execute("netstat -ant");
            break;
        case 4:
            ping_host();
            break;
        case 5:
            exit(EXIT_SUCCESS);
        default:
            puts("Invalid choice!");
        }
    }
    return 0;
}

// gcc -mtune=generic -O1 -pipe -fno-plt -fexceptions -Wp,-D_FORTIFY_SOURCE=3 -Wformat -Werror=format-security -fstack-clash-protection -fcf-protection -fno-omit-frame-pointer -mno-omit-leaf-frame-pointer -Wl,-O1 -Wl,--sort-common -Wl,--as-needed -Wl,-z,relro -Wl,-z,now inject.c -o pwn
