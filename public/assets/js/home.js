let navPlusBtn = document.getElementById('nav-plus');
let newBoardBtn = document.getElementById('new-board');
let popup = document.getElementById('popup');
let saveBoardBtn = document.getElementById('save-board');
let cancelBoardBtn = document.getElementById('cancel-board');
let cancelActionsBtn = document.getElementById('cancel-actions');
let inputNameBoard = document.getElementById('input-name-board');

let popupAction = document.getElementById('popup-action');
let popupBox = document.querySelector('.popup_box');
let popupBoxTitle = document.querySelector('.popup-box-title');
let changeTitleBtn = document.getElementById('change-title-btn');
let deleteBoardBtn = document.getElementById('delete-board-btn');
let productivityEmplBtn = document.getElementById('productivity-empl-btn');
let closeProductivityPopup = document.getElementById('close-productivity');
let progressTaskBtn = document.getElementById('progress-task-btn');
let closeProgressTaskPopup = document.getElementById('close-progress');
let changeAvatarBtn = document.getElementById('camera');
let colorPalette = document.getElementById('avatar-picker');
let avatar = document.getElementById('avatar');
let popupProductivity = document.querySelector('.popup-productivity');
let popupProgressTask = document.querySelector('.popup-progress');

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

navPlusBtn.addEventListener('click', function() {
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
        handleAPI("/boards/" + popupAction.getAttribute('data-id-board'), setTokenToData("", ""), "GET", "board");
        popupBox.classList.toggle('hide');
    }
});

productivityEmplBtn.addEventListener('click', function () {
    popupAction.classList.add('hide');
    if (popupProductivity.classList.contains('hide')) {
        let id = popupAction.getAttribute('data-id-board');
        handleAPI("/boards/productivity", setTokenToData("id", id), "POST", "board");
        popupProductivity.classList.toggle('hide');
    }
});

closeProductivityPopup.addEventListener('click', function () {
    popupProductivity.classList.toggle('hide');
});

function renderProductivity(data) {
    data.users.map(x => {
        x['completed'] = 0;
        x['pending'] = 0;
    })

    data.tasks.forEach(x => {
        const user = data.users.find(y => x.user_id === y.id);
        if (user) {
            user[x.status]++;
        }
    });

    const users = data.users.filter(x => x?.completed > 0 || x?.pending > 0);
    var labels = [];
    var dataCompleted = [];
    var dataPending = [];
    users.forEach(x => {
        labels.push(x?.name);
        dataCompleted.push(x?.completed);
        dataPending.push(x?.pending);
    });

    Chart.defaults.global.defaultFontColor = '#FFFFFF';
    Chart.defaults.global.defaultFontFamily = 'Arial';
    var lineChart = document.getElementById('line-chart-productivity');
    var myChart = new Chart(lineChart, {
        type: 'line',
        data: {
            labels: [...labels],
            datasets: [
                {
                    label: 'Hoàn thành',
                    data: [...dataCompleted],
                    backgroundColor: 'rgba(252, 252, 252, 0.5)',
                    borderColor: 'rgba(5, 255, 5, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Đang xử lý',
                    data: [...dataPending],
                    backgroundColor: 'rgba(252, 252, 252, 0.5)',
                    borderColor: 'rgba(252, 3, 3, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
        }
    });
}

progressTaskBtn.addEventListener('click', function () {
    popupAction.classList.add('hide');
    if (popupProgressTask.classList.contains('hide')) {
        let id = popupAction.getAttribute('data-id-board');
        handleAPI("/boards/progress", setTokenToData("id", id), "POST", "board");
        popupProgressTask.classList.toggle('hide');
    }
});

closeProgressTaskPopup.addEventListener('click', function () {
    popupProgressTask.classList.toggle('hide');
});

function renderProgressTask(data) {
    var month = 12;
    var labels = [];
    var dataCompleted = [];
    var dataPending = [];

    const colorCompleted = 'rgba(5, 255, 5, 1)';
    const colorPending = 'rgba(252, 3, 3, 1)';
    const colorSchedule = 'rgba(10, 80, 245, 1)';
    var borderCorlorCompleted = [];
    var borderCorlorPending = [];

    data?.tasks.forEach(x => {
        if (x?.expected_date != null && x?.dead_line != null) {
            labels.push(x?.title);
            borderCorlorCompleted.push(colorSchedule);
            if (x?.status === 'completed') {
                borderCorlorPending.push(colorCompleted);
            } else {
                borderCorlorPending.push(colorPending);
            }

            const timeComplete = {
                t: x?.expected_date,
                y: x?.expected_date
            }
            dataCompleted.push(timeComplete);
            const timePending = {
                t: x?.dead_line,
                y: x?.dead_line
            }
            dataPending.push(timePending);
            const monthChoose = new Date(x?.expected_date).getMonth() < new Date(x?.dead_line).getMonth()
                                ? new Date(x?.expected_date).getMonth() + 1 : new Date(x?.dead_line).getMonth() + 1;
            month = month < monthChoose ? month : monthChoose;
        }
    });

    var timeInit = "";
    if (month < 10) {
        timeInit = "2022-0" + month + "-01";
    } else {
        timeInit = "2022-" + month + "-01";
    }

    labels = [timeInit, ...labels];
    dataCompleted = [
        {
            t: timeInit,
            y: timeInit
        },
        ...dataCompleted
    ];
    dataPending = [
        {
            t: timeInit,
            y: timeInit
        },
        ...dataPending
    ];

    borderCorlorCompleted = [colorSchedule, ...borderCorlorCompleted];
    borderCorlorPending = [colorPending, ...borderCorlorPending];

    Chart.defaults.global.defaultFontColor = '#FFFFFF';
    Chart.defaults.global.defaultFontFamily = 'Arial';
    var lineChart = document.getElementById('line-chart-progress');
    var myChart = new Chart(lineChart, {
        type: 'line',
        data: {
            labels: [...labels],
            datasets: [
                {
                    label: 'Dự kiến',
                    data: [...dataCompleted],
                    backgroundColor: [
                        'rgba(252, 252, 252, 0.5)'
                    ],
                    borderColor: [...borderCorlorCompleted],
                    borderWidth: 1
                },
                {
                    label: 'Đang thực hiện',
                    data: [...dataPending],
                    backgroundColor: [
                        'rgba(252, 252, 252, 0.5)'
                    ],
                    borderColor: [...borderCorlorPending],
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    type: 'time',
                    distribution: 'linear'
                }]
            }
        }
    });
}

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
                            popupBoxTitle.textContent = "Bạn có chắc chắn muốn xóa bảng " + response?.data?.title + "?";
                        } else {
                            const data = response?.data;
                            for (let i = 0; i < data.length; i++) {
                                renderBoard(data[i].id, data[i].title);
                            }
                        }
                        break;
                    case POST:
                        let spiltBoardUrl = url.split('/');
                        if (spiltBoardUrl[2] !== "") {
                            switch (spiltBoardUrl[2]) {
                                case "productivity":
                                    renderProductivity(response?.data);
                                    break;
                                case 'progress':
                                    renderProgressTask(response?.data);
                                    break;
                            }
                        } else {
                            renderBoard(response?.data?.id, response?.data?.title);
                            showAlertMessage(ADD_BOARD_SUCCESS, true);
                        }
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