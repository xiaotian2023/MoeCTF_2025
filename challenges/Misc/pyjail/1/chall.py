def chall():
    user_input = input("Give me your code: ")

    # 过滤关键字
    forbidden_keywords = ['import', 'eval', 'exec', 'open', 'file']
    for keyword in forbidden_keywords:
        if keyword in user_input:
            print(f"Forbidden keyword detected: {keyword}")
            return

    result = eval(user_input)