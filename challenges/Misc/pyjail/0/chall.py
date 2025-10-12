def chall():
    file_path = input("Guess where the flag is and then give me its file path: ").strip()
    try:
        with open(file_path, 'r', encoding='utf-8') as f:
            file_content = f.read()
            print(f"File content:\n{file_content}")
    except FileNotFoundError:
        print("File not found!")
    except PermissionError:
        print("Permission denied!")
    except Exception as e:
        print(f"Error reading file: {str(e)}")