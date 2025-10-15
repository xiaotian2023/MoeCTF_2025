#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

#define GESTURES 8

size_t n_gestures = 0;
char talks[GESTURES][16] = {0};
void *gestures[GESTURES] = {0};

void execute(void **gestures) {
    for (size_t i = 0; i < n_gestures; ++i) {
        void (*gesture)(void) = gestures[i];
        gesture();
        printf("%s", talks[i]);
        sleep(1);
    }
}

void walk(void) { printf("[Walking] "); }

void wave_hands(void) { printf("[Waving hands] "); }

void jump(void) { printf("[Jumping] "); }

void stand_still(void *_) { printf("... "); }

void unreachable() { system("cat meow~"); }

__attribute((naked)) void gift() {
    asm volatile("mov rax, rdi\n"
                 "mov rdi, [rax + 0x8]\n"
                 "call [rax + 0x10]\n"
                 "ret\n");
}

void turn(void) { printf("[Turning around] "); }

void program(void) {
    for (size_t i = 0; n_gestures < GESTURES; ++i) {
        puts("0. Finish\n1. Walk\n2. Wave Hands\n3. Jump\n4. Turn around\n5. "
             "Stand still");
        unsigned choice;
        printf("Choose your gesture: ");
        if (scanf("%u", &choice) <= 0) {
            exit(EXIT_FAILURE);
        }
        switch (choice) {
        case 0:
            return;
        case 1:
            gestures[i] = walk;
            ++n_gestures;
            break;
        case 2:
            gestures[i] = wave_hands;
            ++n_gestures;
            break;
        case 3:
            gestures[i] = jump;
            ++n_gestures;
            break;
        case 4:
            gestures[i] = turn;
            ++n_gestures;
            break;
        case 5:
            gestures[i] = stand_still;
            ++n_gestures;
            break;
        default:
            puts("Invalid choice, try again.");
            continue;
        }
        printf("What should I say after this gesture? ");
        getchar();
        if (fgets(talks[i], sizeof(talks[i]), stdin) == NULL) {
            exit(EXIT_FAILURE);
        }
    }
}

int main(void) {
    setbuf(stdout, NULL);

    puts("[[ Programmable MoeBot v1.0 ]]\nPlease specify the gestures.");

    program();

    printf("Registered %zu gestures. Executing the program...\n", n_gestures);

    execute(gestures);

    exit(EXIT_SUCCESS);
}

// gcc -mtune=generic -pipe -fno-plt -fexceptions -Wformat -Werror=format-security -fstack-clash-protection -fcf-protection -fno-omit-frame-pointer -mno-omit-leaf-frame-pointer -no-pie -Wl,--sort-common -Wl,--as-needed -Wl,-z,relro -Wl,-z,now main.c -masm=intel -o pwn