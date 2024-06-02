@extends('layouts.app')

@section('style')
    <style>
        .item img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 5px;
        }
        .item {
            display: flex;
            padding: 10px;
            align-items: center;
            background: rgb(239, 237, 237);
        }
        .item:hover {
            opacity: 0.8;
        }
        .status {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: green;
        }
        .block-chat {
            width: 100%;
            height: 450px;
            border: 1px solid rgb(237, 234, 234);
            overflow-y: scroll;
            padding: 10px;
            background-color: #f5f5f5;
        }
        .message {
            display: flex;
            margin-bottom: 10px;
            align-items: flex-start;
        }
        .message img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .message-content {
            max-width: 70%;
            padding: 10px;
            border-radius: 15px;
            background-color: #ffffff;
            position: relative;
        }
        .message-content:before {
            content: "";
            position: absolute;
            top: 10px;
            left: -10px;
            border-width: 10px;
            border-style: solid;
            border-color: transparent #ffffff transparent transparent;
        }
        .my-mes {
            display: flex;
            justify-content: flex-end;
        }
        .my-mes .message-content {
            background-color: #dcf8c6;
            text-align: right;
        }
        .my-mes .message-content:before {
            left: auto;
            right: -10px;
            border-color: transparent transparent transparent #dcf8c6;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                @foreach ($users as $user)
                    <a href="" class="item" id="link_{{$user->id}}">
                        <div class="col-md-12">
                            <img src="{{$user->image}}" alt="">
                            <p>{{$user->name}}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="col-md-9">
            <ul class="block-chat">
                <!-- Chat messages will be appended here dynamically -->
            </ul>
            <form>
                <div class="d-flex">
                    <input type="text" class="form-control me-5" id="inputChat">
                    <button type="button" class="btn btn-success" id="sent">SEND</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="module">
        Echo.join('chat')
            .here(users => {
                users.forEach(item => {
                    let el = document.querySelector(`#link_${item.id}`);
                    let elementStatus = document.createElement('div');
                    elementStatus.classList.add('status');
                    if (el) {
                        el.appendChild(elementStatus);
                    }
                });
            })
            .joining(user => {
                let el = document.querySelector(`#link_${user.id}`);
                let elementStatus = document.createElement('div');
                elementStatus.classList.add('status');
                if (el) {
                    el.appendChild(elementStatus);
                }
            })
            .leaving(user => {
                let el = document.querySelector(`#link_${user.id}`);
                let elementStatus = el.querySelector('.status');
                if (elementStatus) {
                    el.removeChild(elementStatus);
                }
            })
            .listen('UserOnline', event => {
                let blockChat = document.querySelector('.block-chat');
                let elementChat = document.createElement('li');
                elementChat.classList.add('message');

                let imgElement = document.createElement('img');
                imgElement.src = event.user.image;
                elementChat.appendChild(imgElement);

                let contentElement = document.createElement('div');
                contentElement.classList.add('message-content');
                contentElement.textContent = event.user.name + ": " + event.mess;

                elementChat.appendChild(contentElement);

                if (event.user.id == "{{ Auth::user()->id }}") {
                    elementChat.classList.add('my-mes');
                }

                blockChat.appendChild(elementChat);
            });

        let inputChat = document.querySelector('#inputChat');
        let sent = document.querySelector('#sent');

        sent.addEventListener('click', function () {
            axios.post('{{ route("sent") }}', {
                message: inputChat.value,
            }).then(data => {
                console.log(data.data.success);
            });
        });
    </script>
@endsection
