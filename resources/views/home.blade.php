<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Home</title>
	<link href="{{ asset('assets/css/general.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/home.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">
</head>

<body>
	<div id="root" class="root">
		<!-- navigation -->
		<div class="nav">
		    <div class="nav-dashboard">
                <a href="#" class="nav-btn">
                    <i class="fa fa-border-all"></i>
                </a>
            </div>

            <div class="nav-home">
                <a href="#" class="nav-btn">
                    <i class="fa fa-home"></i>
                </a>
            </div>

            <div class="nav-board">
                <a href="#" class="nav-btn">
                    <i class="fab fa-trello"></i>
                    <span>Bảng</span>
                </a>
            </div>

            <div class="nav-search">
                <input type="text" name="" id="" onfocus="inputTextFunc()">
                <i class="fas fa-search"></i>
                <i class="fas fa-times hide"></i>
            </div>

            <div class="logo">
                <i class="fab fa-asymmetrik"></i>
                <span>TasksManager</span>
            </div>

			<div class="nav-icons-right">
                <div class="nav-plus" id="nav-plus">
                    <a href="#" class="nav-btn">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>

                <div class="nav-info">
                    <a href="#" class="nav-btn">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </div>

                <div class="nav-notifications">
                    <a href="#" class="nav-btn">
                        <i class="far fa-bell"></i>
                    </a>
                </div>

                <div class="member-badge mod-round center">
                    <span>An</span>
                </div>
            </div>
		</div>

		<!-- content -->
		<div class="main-content background-content">
			<!-- sidebar -->
			<div class="sidebar">
				<div class="user-section">
					<div id="avatar" class="avatar" data-id="{{ Auth::user()->id }}" data-id-user="{{ Auth::user()->name }}" data-avatar="{{ Auth::user()->avatar }}">
						<span>{{ str_split(Auth::user()->name)[0] }}</span>
						<div id="camera" class="camera">
							<i class="fas fa-camera"></i>
						</div>
						<!-- upload files -->
						<div id="pencil" class="pencil">
							<label for="upload_avatar"><i class="fas fa-edit"></i></label>
							<input type="file" id="upload_avatar" name="upload_avatar" hidden>
						</div>
					</div>
					<div style="width: 100%;height: 2px; background-color: dimgray;margin: 20px 0;"></div>
					<div class="btn">
						<i class="fab fa-trello"></i>
						<span>Bảng</span>
					</div>
					<div class="btn">
						<i class="fas fa-user"></i>
						<a href="/profile">Hồ sơ</a>
					</div>
					<div class="btn">
						<i class="fas fa-door-open"></i>
						<a id="logout" href="{{ route('logout') }}" style="text-decoration: none;" onclick="event.preventDefault();
										document.getElementById('logout-form').submit();">
							Thoát
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</div>
				</div>
			</div>

			<!-- Nội dung bảng -->
			<div class="container">
				<div class="board-section">
					<div class="board-title">
						<span><i class="fas fa-user"></i></span>
						<span>Bảng cá nhân</span>
					</div>

					<div id="board-wrapper" class="board-wrapper">
						<div id="new-board" class="board new-board">
							<i class="fas fa-plus"></i>
							<span>Tạo bảng mới</span>
						</div>
					</div>

				</div>
			</div>
		</div>

		<!-- Bảng hiển thị thêm/sửa bảng -->
		<div id="popup" class="popup hide">
			<div class="new-board-box">
				<input type="text" name="" id="input-name-board" placeholder="Nhập tên bảng" autocomplete="off" spellcheck="false">
				<div class="popup-control">
					<button id="save-board" class="change-btn" type="button">Tạo bảng</button>
					<button id="cancel-board" class="unchange-btn" type="button"><i class="fas fa-times"></i></button>
				</div>
			</div>
		</div>

		<!-- Bảng hiển thị sửa/xóa bảng -->
		<div id="popup-action" class="popup-action hide" data-id-board="">
            <div class="popup-title">
                <span>Thao tác</span>
            </div>
            <div class="popup-horizontal"></div>
            <div id="change-title-btn" class="popup-btn">Sửa tên bảng</div>
            <div id="delete-board-btn" class="popup-btn">
				<span>Xóa bảng</span>
			</div>
            <button id="cancel-actions" class="unchange-btn" type="button"><i class="fas fa-times"></i></button>
        </div>

		<!-- Bảng chọn màu cho avatar -->
		<div id="avatar-picker" class="avatar-picker hide">
			<div class="popup-title">
				<span>Chọn màu</span>
				<span id="cancel-avatar-picker" class="unchange-btn">
				    <i class="fas fa-times"></i>
				</span>
			</div>	
			<div class="popup-horizontal"></div>
			<div class="color-palette"></div>
		</div>

		<!-- Hiển thị thông điệp trả về -->
		<div class="alert hide-alert">
			<!-- <span class="fa fa-check-circle"></span>
			<span><i class="fas fa-exclamation-triangle"></i></span> 
			<span class="msg"></span>
			<span class="close-btn">
				<span class="fas fa-times"></span>
			</span> -->
		</div>

		<!-- modal xóa bảng -->
		<div class="popup_box hide">
			<div class="modal-delete">
				<i class="fas fa-exclamation"></i>
				<h1 class="popup-box-title"></h1>
				<div class="btns">
					<a href="#" class="btn1">Hủy</a>
					<a href="#" class="btn2">Xóa</a>
				</div>
			</div>
		</div>
	</div>

	<script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
	<script src="{{ asset('assets/js/constants.js') }}"></script>
	<script src="{{ asset('assets/js/ultilities.js') }}"></script>
	<script src="{{ asset('assets/js/home.js') }}"></script>
	<script type="text/javascript">
		handleAPI("/boards/", {}, "GET", "board");
		createColorPalatte();

		let navSearch = document.querySelector('.nav-search');
		let cancelSearch = navSearch.querySelector('.fa-times');
		let inputText = navSearch.querySelector('input[type="text"]');

		function inputTextFunc() {
			cancelSearch.classList.remove('hide');
		}

		document.addEventListener('click', function(event) {
			var isClickInside = inputText.contains(event.target);
			if (!isClickInside) {
				inputText.value = '';
				cancelSearch.classList.add('hide');
			}
		});

		const uploadAvatar = document.querySelector('#upload_avatar');
		let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;
		uploadAvatar.addEventListener('change', function() {
            let file = this.files[0];
            if (file) {
				let fileName = this.value.match(regExp);
				console.log(fileName[0]);
                handleAPI("/users", setTokenToData("avatar", fileName[0]), "POST", "user");
            }
        });
	</script>
</body>

</html>