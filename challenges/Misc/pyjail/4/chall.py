import ast
import base64

# 自定义 AST 节点访问器来限制可用的语法结构
class RestrictedNodeVisitor(ast.NodeVisitor):
    forbidden_attrs = {
        "__class__", "__dict__", "__bases__", "__mro__", "__subclasses__",
        "__globals__", "__code__", "__closure__", "__func__", "__self__",
        "__module__", "__import__", "__builtins__", "__base__", "__init__", "__getattribute__"
    }
    def visit_Attribute(self, node):
        # 禁止危险属性访问
        if isinstance(node.attr, str) and node.attr in self.forbidden_attrs:
            raise RuntimeError(f"Access to attribute '{node.attr}' is forbidden!")
        self.generic_visit(node)

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
        safe_builtins = {
            "print": print,
            "filter": filter,
            "list": list,
            "len": len,
            "Exception": Exception
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