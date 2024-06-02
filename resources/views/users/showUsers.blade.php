@extends('layouts.app')

@section('style')

    <style>
        .user-image{
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalApp">Them Moi</button>
    <table class="table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Name</th>
                <th>Image</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbody">
            @foreach ($users as $key => $user)
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{$user->name}}</td>
                    <td>
                        <img src="{{$user->image}}" class="user-image" alt="">
                    </td>
                    <td>{{$user->email}}</td>
                    <td>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="{{ $user->id }}">Sua</button>
                        <button class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#modalDelete" data-id="{{ $user->id }}">Xoa</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection

    <!-- Modal -->
    <div class="modal fade" id="modalApp" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="ModalLabel">Them Moi</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="" class="form-label">Name</label>
                    <input type="text" class="form-control" name="" id="name">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">email</label>
                    <input type="email" class="form-control" name="" id="email">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Image</label>
                    <input type="text" class="form-control" name="" id="image">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Dong</button>
            <button type="button" class="btn btn-primary" id="btnAddUser">Them Moi</button>
            </div>
        </div>
        </div>
    </div>
    <!-- Modal -->
    <input type="hidden" id="userIdUpdate">
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="ModalLabel">Chinh Sua</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="" class="form-label">Name</label>
                    <input type="text" class="form-control" name="" id="nameUp">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">email</label>
                    <input type="email" class="form-control" name="" id="emailUp">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Image</label>
                    <input type="text" class="form-control" name="" id="imageUp">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Dong</button>
            <button type="button" class="btn btn-primary" id="btnUpdateUser">Chinh Sua</button>
            </div>
        </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="ModalLabel">Xoa/h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1>Ban co muon Xoa</h1>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Dong</button>
            <button type="button" class="btn btn-primary" id="btnDelete">Xac Nhan</button>
            </div>
        </div>
        </div>
    </div>
@section('script')
    <script type="module">

        let name = document.querySelector('#name')
        let image = document.querySelector('#image')
        let email = document.querySelector('#email')

        function ref(){
            name.value = ''
            image.value = ''
            email.value = ''
        }

        btnAddUser.addEventListener('click', function() {
            axios.post('{{route("postAddUser")}}', {
                name: name.value,
                email: email.value,
                image: image.value
            })
            .then((response) => {
                console.log(response.data);
                let modalAdd = document.querySelector('#modalApp');
                let close = modalAdd.querySelector('.btn-close');
                close.click();
                ref()
            })
            .catch((error) => {
                console.error(error);
                // Xử lý lỗi (hiển thị thông báo cho người dùng, v.v.)
            });
        });


        // update

        let nameUp = document.querySelector('#nameUp')
        let imageUp = document.querySelector('#imageUp')
        let emailUp = document.querySelector('#emailUp')

        function refUp(){
            nameUp.value = ''
            imageUp.value = ''
            emailUp.value = ''
        }

        const modalEdit = document.getElementById('modalEdit')
        if (modalEdit) {
            modalEdit.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-id');
            axios.post('{{route("postDetalUser")}}', {
                id
            })
            .then(data => {
                nameUp.value = data.data.name
                imageUp.value = data.data.image
                emailUp.value = data.data.email
                userIdUpdate.value = id
            })
        })
        }
        let btnUpdateUser = document.querySelector('#btnUpdateUser');
        btnUpdateUser.addEventListener('click', function() {
            axios.post('{{route("postUpdateUser")}}', {
                name: nameUp.value,
                email: emailUp.value,
                image: imageUp.value,
                id: userIdUpdate.value
            })
            .then((response) => {
                console.log(response.data);
                let modalAdd = document.querySelector('#modalEdit');
                let close = modalAdd.querySelector('.btn-close');
                close.click();
                refUp()
            })
        });

        //Delete
        var idDelete
        var modalDelete = document.getElementById('modalDelete')
        if (modalDelete) {
            modalDelete.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-* attributes
            idDelete = button.getAttribute('data-id');
            console.log(idDelete);
            })
        }

        let btnDelete = document.querySelector('#btnDelete');
        btnDelete.addEventListener('click', function(){
            axios.post('{{route("postDeleteUser")}}',{
                id: idDelete
            })
            .then(data =>{
                console.log(data);
                let modalDelete = document.querySelector('#modalDelete');
                let close = modalDelete.querySelector('.btn-close');
                close.click();
            })
        })

        // Lang nghe su kien CURD

        Echo.channel('users')
            .listen('UserCreate', event => {
                console.log(event.user);
                let UI = `
                    <tr>
                        <td></td>
                        <td>${event.user.name}</td>
                        <td>
                            <img src="${event.user.image}" class="user-image" alt="">
                        </td>
                        <td>${event.user.email}</td>
                        <td>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit" data-id="${event.user.id}">Sua</button>
                            <button class="btn btn-danger"  data-bs-toggle="modal" data-bs-target="#modalDelete" data-id="${event.user.id}">Xoa</button>
                        </td>
                    </tr>
                `
                let tbody = document.querySelector('#tbody');
                tbody.insertAdjacentHTML("afterbegin", UI);
            })
    </script>
@endsection
