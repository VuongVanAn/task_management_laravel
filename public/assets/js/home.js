let newBoardBtn = document.getElementById('new-board');
let popup = document.getElementById('popup');
let saveBoardBtn = document.getElementById('save-board');
let cancelBoardBtn = document.getElementById('cancel-board');
let cancelActionsBtn = document.getElementById('cancel-actions');
let inputNameBoard = document.getElementById('input-name-board');

let popupAction = document.getElementById('popup-action');
let popupBox = document.querySelector('.popup_box');
let changeTitleBtn = document.getElementById('change-title-btn');
let deleteBoardBtn = document.getElementById('delete-board-btn');
let changeAvatarBtn = document.getElementById('camera');
let colorPalette = document.getElementById('avatar-picker');
let avatar = document.getElementById('avatar');

let colorIndex = 0;

if (!avatar.getAttribute('data-avatar') === "") {
    avatar.firstElementChild.innerHTML = "";
    avatar.style.background = "url('/assets/avatars/" + avatar.getAttribute('data-avatar') + "')";
    avatar.style.backgroundSize = "cover";
    avatar.style.backgroundPosition = "center";
    avatar.style.backgroundRepeat = "no-repeat";
}

//Nút ở sidebar
let btnGroup = document.querySelectorAll(".btn");
btnGroup.forEach(function(btn) {
    btn.addEventListener('click', function() {
        btnGroup.forEach(function(btn) {
            btn.className = "btn";
        });
        if (!this.classList.contains('is-clicked')) {
            this.classList.toggle('is-clicked');
        } else {
            this.classList.toggle('is-clicked');
        }
    });
});

//Load board từ JSON trả về
function renderBoard(boardId, boardName) {
    let boardWrapper = document.getElementById('board-wrapper');
    let newBoard = document.createElement('a');
    newBoard.href = "/board/" + boardId;
    newBoard.className = "board background";
    newBoard.setAttribute('data-id-board', boardId);
    setBackGround(newBoard);

    let newBoardName = document.createElement('div');
    newBoardName.className = "board-name";
    newBoardName.innerHTML = "<span>" + boardName + "</span>";

    let newBoardControl = document.createElement('div');
    newBoardControl.className = "board-control";
    newBoardControl.innerHTML = "<i class=\"fas fa-sliders-h\"></i>";

    newBoardControl.addEventListener('click', function(e) {
        e.preventDefault();
        if (popupAction.getAttribute('data-id-board') === boardId) {
            popupAction.className = "popup-action hide";
            popupAction.setAttribute('data-id-board', "");
        } else {
            popupAction.className = "popup-action";
            popupAction.setAttribute('data-id-board', boardId);
        }
        setPosition(this, popupAction, 0, 40);
    });

    newBoard.appendChild(newBoardName);
    newBoard.appendChild(newBoardControl);
    boardWrapper.insertBefore(newBoard, newBoardBtn);
}

//Update board từ JSON trả về
function updateBoard(boardId, boardName) {
    let boardWrapper = document.getElementById('board-wrapper');
    let hrefBounds = boardWrapper.querySelector('a[href="/board/' + boardId + '"]');
    let spanName = hrefBounds.querySelector('.board-name span');
    spanName.textContent = boardName;
}

newBoardBtn.addEventListener('click', function() {
    saveBoardBtn.innerHTML = 'Tạo bảng';
    if (popup.classList.contains('hide')) {
        popup.classList.toggle('hide');
        inputNameBoard.focus();

        inputNameBoard.oninput = function(e) {
            if (e.target.value) {
                saveBoardBtn.classList.add('active');
            } else {
                saveBoardBtn.classList.remove('active');
            }
        }
    }
});

function setInputText(title) {
    inputNameBoard.value = title;
}

changeTitleBtn.addEventListener('click', function() {
    popupAction.classList.add('hide');
    saveBoardBtn.innerHTML = 'Cập nhật';
    handleAPI("/boards/" + popupAction.getAttribute('data-id-board'), setTokenToData("", ""), "GET", "board");
    if (popup.classList.contains('hide')) {
        if (inputNameBoard.value != null) {
            saveBoardBtn.classList.add('active');
        }

        popup.classList.toggle('hide');
        inputNameBoard.focus();

        inputNameBoard.oninput = function(e) {
            if (e.target.value) {
                saveBoardBtn.classList.add('active');
            } else {
                saveBoardBtn.classList.remove('active');
            }
        }
    }
});

saveBoardBtn.addEventListener('click', function(e) {
    e.preventDefault();
    let id = popupAction.getAttribute('data-id-board');
    if (inputNameBoard.value) {
        if (id) {
            handleAPI("/boards/" + id, setTokenToData("title", inputNameBoard.value), "PUT", "board");
            popup.classList.toggle('hide');
        } else {
            handleAPI("/boards", setTokenToData("title", inputNameBoard.value), "POST", "board");
            popup.classList.toggle('hide');
        }
    }
});

deleteBoardBtn.addEventListener('click', function() {
    popupAction.classList.add('hide');
    if (popupBox.classList.contains('hide')) {
        console.log(handleAPI("/boards/" + popupAction.getAttribute('data-id-board'), setTokenToData("", ""), "GET", "board"));
        popupBox.classList.toggle('hide');
    }
});

popupBox.querySelector('.btns .btn1').addEventListener('click', function() {
    popupBox.classList.toggle('hide');
});

popupBox.querySelector('.btns .btn2').addEventListener('click', function() {
    handleAPI("/boards/" + popupAction.getAttribute('data-id-board'), setTokenToData("", ""), "DELETE", "board");
    popupBox.classList.toggle('hide');
});

cancelBoardBtn.addEventListener('click', function() {
    popup.classList.toggle('hide');
    inputNameBoard.value = "";
});

cancelActionsBtn.addEventListener('click', function() {
    popupAction.classList.toggle('hide');
});

changeAvatarBtn.addEventListener('click', function() {
    colorPalette.classList.toggle('hide');
    setPosition(changeAvatarBtn, colorPalette, 0, 40);
});

function setBackGround(board) {
    let index = parseInt(board.getAttribute('data-id-board')) % 10;
    let url = "assets/img/bg" + index + ".jpg";
    board.style.background = "url('" + url + "')";
    board.style.backgroundPosition = "center";
    board.style.backgroundRepeat = "no-repeat";
    board.style.backgroundSize = "cover";
}

//Chọn màu cho avatar
function resetAllColor() {
    let palette = colorPalette.children[2];
    for (let i = 0; i < palette.childElementCount; i++) {
        palette.children[i].className = "color";
    }
}

function createColorPalatte() {
    var hex = ["#6bc950", "#ff533c", "#5b5eff", "#ff7fab", "#000"];
    hex.forEach(function(colorHex) {
        let color = document.createElement('div');
        color.className = "color";
        color.style.backgroundColor = colorHex;
        color.innerHTML = "<i class=\"fas fa-check\"></i>";
        color.addEventListener('click', function() {
            if (!this.classList.contains('picked')) {
                resetAllColor();
                color.className = "color picked";
                let styleElement = document.head.appendChild(document.createElement("style"));
                styleElement.innerHTML = `.avatar:before {background: ${colorHex};}`;
            }
        });
        colorPalette.children[2].appendChild(color);
    });

    colorPalette.children[0].addEventListener('click', function() {
        colorPalette.classList.toggle('hide');
    });
}

//Xử lý các truy vấn API tới cho server và nhận phản hồi về để hiển thị ra màn hình
function handleAPI(url, data, method, type) {
    $.ajax({
        url: url,
        type: method,
        data: data,
        success: function(response) {
            //Xử lý các truy vấn với bảng
            if (type === BOARD) {
                switch (method) {
                    case GET:
                        let splitUrl = url.split('/');
                        if (splitUrl[2] !== "") {
                            setInputText(response?.data?.title);
                        } else {
                            const data = response?.data;
                            for (let i = 0; i < data.length; i++) {
                                renderBoard(data[i].id, data[i].title);
                            }
                        }
                        break;
                    case POST:
                        renderBoard(response?.data?.id, response?.data?.title);
                        showAlertMessage(ADD_BOARD_SUCCESS, true);
                        break;
                    case PUT:
                        updateBoard(response?.data?.id, response?.data?.title);
                        showAlertMessage(UPDATE_BOARD_SUCCESS, true);
                        break;
                    case DELETE:
                        deleteBoard();
                        showAlertMessage(DELETE_BOARD_SUCCESS, true);
                        break;
                }
            } else if (type === USER) {
                switch (method) {
                    case POST:
                        console.log(response);
                        avatar.setAttribute("data-avatar", response.avatar);
                        break;
                }
            }
        },
        error: function(request, status, error) {
            showAlertMessage(status, false);
        }
    });
}