import ast
import base64

# 自定义 AST 节点访问器来限制可用的语法结构
class RestrictedNodeVisitor(ast.NodeVisitor):
    def visit_Attribute(self, node):
        # 禁止属性访问
        raise RuntimeError(f"Access to any attributes is forbidden!")

def chall():
    user_input = input("Give me your code after base64 encoding it: ")
    code = base64.b64decode(user_input).decode('utf-8')
    
    if not user_input:
        print("Empty input!")
        return
    
    try:
        # 使用 AST 解析和验证代码
        tree = ast.parse(code)
        visitor = RestrictedNodeVisitor()
        visitor.visit(tree)
        
        # 创建受限的执行环境
        # maybe useful
        safe_builtins = {
            "Exception": Exception,
            "object": object,
        }

        safe_globals = {"__builtins__": safe_builtins}
        
        # 执行用户代码
        exec(code, safe_globals, {})
        
        print("Code executed successfully!")
            
    except SyntaxError as e:
        print(f"Syntax Error: {e}")
    except RuntimeError as e:
        print(f"Runtime Error: {e}")
    except Exception as e:
        print(f"Execution Error: {type(e).__name__}: {e}")