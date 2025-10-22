# 使用官方 Python 镜像（轻量级版本）
FROM python:3.9-slim

# 设置工作目录
WORKDIR /app

# 复制依赖文件并安装
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# 复制所有代码到容器
COPY . .

# 暴露 Flask 默认端口（通常 5000）
EXPOSE 5000

# 启动 Flask 应用（假设主文件是 app.py）
CMD ["python", "app.py"]