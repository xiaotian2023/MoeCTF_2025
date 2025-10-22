from flask import Flask, render_template, jsonify, request, session, redirect, url_for
import time
import os

app = Flask(__name__)
app.secret_key = os.urandom(24)

FEED_TARGET = 25
FEED_OVER_TARGET = 114514

@app.route('/')
def index():
    session['dialog_step'] = -1
    session['flag_btn_count'] = 0
    session['feed_count'] = 0
    session['feed_pending'] = False
    return render_template('index.html')

@app.route('/dialog', methods=['POST'])
def dialog():
    req = request.get_json()
    action = req.get('action', 'next')
    step = session.get('dialog_step', -1)
    flag_btn_count = session.get('flag_btn_count', 0)
    feed_count = session.get('feed_count', 0)
    feed_pending = session.get('feed_pending', False)

    if action == 'mirror_flag' and step in [17, 18]:
        session['dialog_step'] = 19
        return my_jsonify({
            "text": "你做到了，这是你的flag:FLAG_PLACEHOLDER。",
            "show_next": False,
            "show_findpwd": False,
            "show_feed": False
        })

    # 对话-1：开场白
    if step == -1:
        if action == 'next':
            session['dialog_step'] = 0
            return my_jsonify({
                "text": "你好，我是耄耋，如你所见，我是一只很乖的小猫，就让我来教你如何打CTF吧！",
                "show_next": True,
                "show_findpwd": False,
                "show_feed": False
            })

    # 对话0
    if step == 0:
        if action == 'next':
            session['dialog_step'] = 1
            return my_jsonify({
                "text": "首先，CTF是什么呢？CTF是‘Capture The Flag’的缩写，所以你只要获得flag就可以了。点击那个flag按钮就做出来了，简单吧！",
                "show_next": False,
                "show_findpwd": False,
                "show_feed": False
            })

    # 对话1：flag按钮多次点击
    if step == 1:
        if action == 'flag':
            flag_btn_count += 1
            session['flag_btn_count'] = flag_btn_count
            if flag_btn_count == 1:
                return my_jsonify({
                    "text": "啊呀，今天早上这个按钮有点不太灵，戳了好几下没反应。我不小心多用了一点力，现在这个按钮凹进去了，你需要从显示屏后面按它。你千万别再按了！",
                    "show_next": True,
                    "show_findpwd": False,
                    "show_feed": False
                })
            elif flag_btn_count == 2:
                return my_jsonify({
                    "text": "你还是别戳了，再戳屏幕要被按钮顶穿了！",
                    "show_next": True,
                    "show_findpwd": False,
                    "show_feed": False
                })
            else:
                return my_jsonify({
                    "text": "让你别戳了你二朵隆吗？（哈",
                    "show_next": True,
                    "show_findpwd": False,
                    "show_feed": False
                })
        elif action == 'next':
            session['dialog_step'] = 2
            return my_jsonify({
                "text": "我可能有办法可以让你按到按钮，前提是你要获得管理员权限。",
                "show_next": True,
                "show_findpwd": False,
                "show_feed": False
            })

    # 对话2
    if step == 2:
        if action == 'next':
            session['dialog_step'] = 3
            return my_jsonify({
                "text": "虽然我是一只很乖的小猫，但是你让我干什么我就干什么，我岂不是很没面子？要不这样吧，点击下面这个按钮可以给我投喂一个小鱼干，vivo50...vivo25就够了，不是很多吧（我难道是一只很坏的小猫咪吗）",
                "show_next": False,
                "show_findpwd": False,
                "show_feed": True
            })

    # 对话3：显示投喂按钮
    if step == 3:
        # 惩罚状态（feed_pending为False，feed_count>FEED_TARGET）
        if feed_count > FEED_TARGET:
            if action == 'feed':
                session['feed_count'] += 1
                feed_count = session['feed_count']
                if feed_count < FEED_TARGET + FEED_OVER_TARGET:
                    return my_jsonify({
                        "text": f"你这么好？那我要赖上你了，再来{FEED_OVER_TARGET - (feed_count - FEED_TARGET)}个小鱼干吧。",
                        "show_next": False,
                        "show_findpwd": False,
                        "show_feed": True
                    })
                else:
                    session['dialog_step'] = 4
                    return my_jsonify({
                        "text": "你是真有耐心……那我告诉你账号吧，我记得是三个问题组成的，第一个问题是{{}}",
                        "show_next": True,
                        "show_findpwd": False,
                        "show_feed": False
                    })
        # 如果已经pending但用户还点feed，进入惩罚
        if feed_pending and action == 'feed':
            session['feed_pending'] = False
            session['feed_count'] += 1
            # 进入惩罚状态
            return my_jsonify({
                "text": f"你这么好？那我要赖上你了，再来{FEED_OVER_TARGET - (session['feed_count'] - FEED_TARGET)}个小鱼干吧。",
                "show_next": False,
                "show_findpwd": False,
                "show_feed": True
            })
        # 正常投喂流程
        if action == 'feed':
            feed_count += 1
            session['feed_count'] = feed_count
            if feed_count < FEED_TARGET:
                return my_jsonify({
                    "text": f"你还差 {FEED_TARGET - feed_count} 个小鱼干。",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": True
                })
            elif feed_count == FEED_TARGET:
                session['feed_pending'] = True
                return my_jsonify({
                    "text": "让我数数是不是刚好够了……",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": True,
                    "pending": True
                })
        elif action == 'pending_check' and feed_pending and feed_count == FEED_TARGET:
            session['dialog_step'] = 4
            session['feed_pending'] = False
            return my_jsonify({
                "text": "我先告诉你账号吧，我记得是三个问题组成的，第一个问题是moectf2024的web方向一共多少个flag？（不包括问卷调查）",
                "show_next": True,
                "show_findpwd": False,
                "show_feed": False
            })
        elif action == 'pending_check':
            # 如果不是正常pending状态，直接返回当前状态，不推进
            if feed_count > FEED_TARGET:
                return my_jsonify({
                    "text": f"你这么好？那我要赖上你了，再来{FEED_OVER_TARGET - (feed_count - FEED_TARGET)}个小鱼干吧。",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": True
                })
            else:
                # 其它情况可以不处理或返回默认
                pass

    # 对话4
    if step == 4:
        if action == 'next':
            session['dialog_step'] = 5
            session['flag_special'] = True  # 标记此时flag按钮要弹出73
            return my_jsonify({
                "text": "第二个问题是moectf2024举办期间，9月1日结束时所有参赛者总分第二是多少分？（北京时间）",
                "show_next": True,
                "show_findpwd": False,
                "show_feed": False
            })

    # 对话5
    if step == 5:
        if action == 'flag':
            # 只在此步弹出73
            if session.get('flag_special'):
                session['flag_special'] = False  # 只弹一次
                session['dialog_step'] = 6      # 直接推进到下一步
                return my_jsonify({
                    "text": "最后一个问题是，我说上一句话的时候，点击flag按钮弹出的数字是什么？",
                    "show_next": True,
                    "show_findpwd": False,
                    "show_feed": False,
                    "flag_popup": True  # 前端据此alert 73
                })
            else:
                return my_jsonify({
                    "text": "按钮已经损坏",
                    "show_next": True,
                    "show_findpwd": False,
                    "show_feed": False
                })
        elif action == 'next':
            session['dialog_step'] = 6
            return my_jsonify({
                "text": "最后一个问题是，我说上一句话的时候，点击flag按钮弹出的数字是什么？",
                "show_next": True,
                "show_findpwd": False,
                "show_feed": False
            })

    # 对话6
    if step == 6:
        if action == 'next':
            session['dialog_step'] = 7
            return my_jsonify({
                "text": "很简单的问题吧，你先只交一个账号试试，密码就输入test就可以知道账号对不对了",
                "show_next": False,
                "show_findpwd": False,
                "show_feed": False
            })

    # 对话7
    if step == 7:
        if action == 'login':
            username = req.get('username', '')
            password = req.get('password', '')
            if username == "241410173" and password == "test":
                session['dialog_step'] = 8
                return my_jsonify({
                    "text": "不对吗？我们来重新校对一下账号。",
                    "show_next": True,
                    "show_findpwd": False,
                    "show_feed": False
                })
            else:
                # 不推进，保持在7
                return my_jsonify({
                    "text": "我确信你不对，回去重新算算。",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": False
                })

    # 对话8
    if step == 8:
        if action == 'next':
            session['dialog_step'] = 9
            return my_jsonify({
                "text": "第一个问题是moectf2024的web方向一共多少个flag？",
                "show_next": True,
                "show_findpwd": False,
                "show_feed": False
            })

    # 对话9
    if step == 9:
        if action == 'next':
            session['dialog_step'] = 10
            return my_jsonify({
                "text": "第二个问题是moectf2024举办期间，9月1日结束时所有参赛者总分第二是多少分？",
                "show_next": True,
                "show_findpwd": False,
                "show_feed": False
            })

    # 对话10
    if step == 10:
        if action == 'next':
            session['dialog_step'] = 11
            return my_jsonify({
                "text": "最后一个问题是，哦我记错了，是我前三句话有几个汉字？",
                "show_next": True,
                "show_findpwd": False,
                "show_feed": False
            })

    # 对话11
    if step == 11:
        if action == 'next':
            session['dialog_step'] = 12
            return my_jsonify({
                "text": "好了，这次一定对。密码还是test。",
                "show_next": False,
                "show_findpwd": False,
                "show_feed": False
            })

    # 对话12
    if step == 12:
        if action == 'login':
            username = req.get('username', '')
            password = req.get('password', '')
            if username == "241410156" and password == "test":
                session['dialog_step'] = 13
                return my_jsonify({
                    "text": "好了，终于对了，这下要输入密码了，牛魔的，都怪你账号乱输，把系统搞坏了，这下不知道密码对不对了，我去后台帮你看看...这怎么还欺负我没过四级，上面写什么Enter password，我看不懂，交给你了。",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": False
                })
            else:
                # 不推进，保持在12
                return my_jsonify({
                    "text": "我确信你不对，回去重新算算。",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": False
                })

    # 对话13
    if step == 13:
        if action == 'login':
            password = req.get('password', '')
            if password == "password":
                session['dialog_step'] = 14
                return my_jsonify({
                    "text": "你这密码包不对啊，我都知道不可能是这个。后台告诉你Your password is incorrect!",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": False
                })
            else:
                # 不推进，保持在13
                return my_jsonify({
                    "text": "你这密码也忒离谱了，后台都给气得爆母语了，告诉你密码错误。",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": False
                })

    # 对话14
    if step == 14:
        if action == 'login':
            password = req.get('password', '')
            if password == "incorrect!":
                session['dialog_step'] = 15
                return my_jsonify({
                    "text": (
                        "我看你是真的没救了，去找回一下密码吧，找回密钥我不小心（故意）弄丢了...怕你太无聊，"
                        "我决定整点烂活，我塞了点假的找回密钥，你猜猜哪一个是真的？"
                        "<span style='opacity:0.02;user-select:all;pointer-events:auto;'>　xbhiuebkjvs　</span>"
                    ),
                    "show_next": False,
                    "show_findpwd": True,
                    "show_feed": False,
                    "html": True  # 关键：让前端用 innerHTML 渲染
                })
            else:
                # 不推进，保持在14
                return my_jsonify({
                    "text": "你这密码也忒离谱了，后台都给气得爆母语了，告诉你密码错误。",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": False
                })

    # 对话15
    if step == 15:
        if action == 'findkey':
            key = req.get('key', '')
            if key == "xbhiuebkjvs":
                session['dialog_step'] = 16
                return my_jsonify({
                    "text": "你这一眼就乱输入的，能对我吃。算了，我直接告诉你密码吧，密码就是******，都怪你之前不是管理员还按了那个按钮，屏幕被弄坏了，密码好像都显示不出来了。",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": False
                })
            else:
                # 不推进，保持在15
                return my_jsonify({
                    "text": "你真的找了吗？",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": False
                })

    # 对话16
    if step == 16:
        if action == 'login':
            username = req.get('username', '')
            password = req.get('password', '')
            if username == "241410156" and password == "******":
                session['dialog_step'] = 17
                session['is_admin'] = True  # 授予管理员权限
                return my_jsonify({
                    "text": "？？我前面全是乱讲的，你还真的登录上去了？",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": False,
                    "is_admin": True  # 前端据此允许打开设置
                })
            else:
                # 不推进，保持在16
                return my_jsonify({
                    "text": "我确信你不对，回去重新找回密码。",
                    "show_next": False,
                    "show_findpwd": False,
                    "show_feed": False,
                    "is_admin": False
                })

    # 对话17
    if step == 17:
        if action == 'setting':
            session['dialog_step'] = 18
            return my_jsonify({
                "text": "好吧，真的要成功了。",
                "show_next": False,
                "show_findpwd": False,
                "show_feed": False
            })

    # 默认兜底
    return ('', 204)

def my_jsonify(data):
    data["is_admin"] = session.get('is_admin', False)
    data["step"] = session.get('dialog_step', -1)
    return jsonify(data)

if __name__ == '__main__':
    app.run(debug=True)