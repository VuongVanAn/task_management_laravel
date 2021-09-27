let listIndex = 0;

//Nạp và khởi tạo các thành phần của danh sách
function loadCard(list, card) {
	var newCard = document.createElement('div');
	newCard.className = "card";
	newCard.draggable = "true";

	setDataCard(newCard, list, card);

	var newCardLabel = document.createElement('div');
	newCardLabel.className = "card-label";
	newCardLabel.innerHTML = card.title;

	var newCardEdit = document.createElement('textarea');
	newCardEdit.className = "card-edit";

	var newCardEditBtn = document.createElement('div');
	newCardEditBtn.className = "btn card-edit-btn";
	newCardEditBtn.innerHTML = "<i class=\"fas fa-pen\"></i>";

	var newCardDeadline = document.createElement('div');
	newCardDeadline.innerHTML = "<i class=\"far fa-clock\"></i><span>" + setDateText(card.dead_line, "") + "</span>";

	newCard.appendChild(newCardLabel);
	newCard.appendChild(newCardEdit);
	newCard.appendChild(newCardEditBtn);

	var newCardDeadline = document.createElement('div');

	if (card.dead_line != null) {
		newCardDeadline.innerHTML = "<i class=\"far fa-clock\"></i><span>" + setDateText(card.dead_line, "") + "</span>";
		if (card.status == "completed") {
			newCardDeadline.className = "date-status is-complete normal";
		} else {
			newCardDeadline.className = setStatusClass(card.dead_line);
		}
	}
	newCard.appendChild(newCardDeadline);
	list.children[1].appendChild(newCard);

	newCard.addEventListener('click', function (e) {
		if (!(e.target.classList.contains("btn"))) {
			let url = "/boards/" + getDataCard(newCard).boardId + "/lists/" + getDataCard(newCard).listId + "/cards/" + getDataCard(newCard).cardId;
			handleAPI(url, {}, "GET", "card");
		}
	});

	newCardEditBtn.addEventListener('click', function (e) {
		newCardEdit.style.zIndex = 1;
		newCardEdit.focus();
	});

	newCardEdit.addEventListener('blur', function () {
		if (newCardEdit.value !== "") {
			newCardLabel.innerHTML = newCardEdit.value;
			let url = "/boards/" + newCard.getAttribute('data-id-board') + "/lists/" + newCard.getAttribute('data-id-list') +
				"/cards/" + newCard.getAttribute('data-id-card');
			handleAPI(url, setTokenToData("title", newCardEdit.value), "PUT", "card");
			newCardEdit.value = "";
		}
		newCardEdit.style.zIndex = -1;
	});

	return newCard;
}

function renderListCard(list, list_card) {
	list_card.forEach((card) => {
		loadCard(list, card);
	});
}

function createListHeader(list, title) {
	let listControl = document.getElementById('list-control');
	var newListHeader = document.createElement('div');
	newListHeader.className = "list-header";

	var newListHeaderTitle = document.createElement('div');
	newListHeaderTitle.className = "list-title";

	var newListHeaderTitleLabel = document.createElement('div');
	newListHeaderTitleLabel.className = "list-title-label";
	newListHeaderTitleLabel.innerHTML = title;

	var newListHeaderTitleEdit = document.createElement('textarea');
	newListHeaderTitleEdit.className = "list-title-edit";

	var newListHeaderExtra = document.createElement('div');
	newListHeaderExtra.className = "list-action center";
	newListHeaderExtra.innerHTML = "<i class=\" fas fa-ellipsis-h \"></i>";
	newListHeaderExtra.addEventListener('click', function () {
		listIndex = list.getAttribute('data-id-list');
		let position = this.getBoundingClientRect();
		let positionTop = position.top;
		let positionLeft = position.left + 40;
		listControl.style.top = positionTop + "px";
		listControl.style.left = positionLeft + "px";
		listControl.classList.toggle('hide');
		setDataListControl(listControl, list);
	});

	newListHeader.appendChild(newListHeaderTitle);
	newListHeader.appendChild(newListHeaderExtra);
	newListHeaderTitle.appendChild(newListHeaderTitleLabel);
	newListHeaderTitle.appendChild(newListHeaderTitleEdit);

	newListHeaderTitleLabel.addEventListener("dblclick", function () {
		newListHeaderTitleEdit.style.zIndex = 1;
		newListHeaderTitleEdit.focus();
	});

	newListHeaderTitleEdit.addEventListener('blur', function () {
		if (newListHeaderTitleEdit.value !== "") {
			newListHeaderTitleLabel.innerHTML = newListHeaderTitleEdit.value;
			let url = "/boards/" + list.getAttribute('data-id-board') + "/lists/" + list.getAttribute('data-id-list');
			handleAPI(url, setTokenToData("title", newListHeaderTitleEdit.value), "PUT", "list");
		}
		newListHeaderTitleEdit.style.zIndex = -1;
	});

	list.appendChild(newListHeader);
	return newListHeader;
}

function createListCard(list) {
	var newListCard = document.createElement('div');
	newListCard.className = "list-card";
	list.appendChild(newListCard);
	return newListCard;
}

//Nạp danh sách từ JSON trả về
function renderList(list, index) {
	console.log(list);
	let boardContent = document.getElementById('board-content');
	let newListWrapper = document.createElement('div');
	newListWrapper.className = "list-wrapper";

	let newList = document.createElement('div');
	newList.className = "list";

	setDataList(newList, list, index);

	createListHeader(newList, list.title);
	createListCard(newList);
	createCardComposerContainer(newList);

	newListWrapper.appendChild(newList);
	boardContent.insertBefore(newListWrapper, addList);

	return newList;
}

//Thao tác xử lý với danh sách
let deleteListBtn = document.getElementById('delete-list');
let listSort = document.getElementById('list-sort');
let listMove = document.getElementById('move-list');

deleteListBtn.addEventListener('click', function () {
	let listControl = document.getElementById('list-control');
	listControl.classList.toggle('hide');
	let url = "/boards/" + listControl.getAttribute('data-id-board') + "/lists/" + listControl.getAttribute('data-id-list');
	handleAPI(url, setTokenToData("", ""), "DELETE", "list");
});

let popUpClose = document.querySelectorAll('.popup-close');
popUpClose.forEach(function (item) {
	item.addEventListener('click', function () {
		this.parentElement.classList.add('hide');
	});
});


//Sắp xếp các thẻ trong danh sách
let listSortOption = document.getElementById('list-sort-option');
let sortByDeadlineUp = document.getElementById('sort-deadline-up');
let sortByDeadlineDown = document.getElementById('sort-deadline-down');
let sortByName = document.getElementById('sort-name');

listSort.addEventListener('click', function () {
	setPosition(listSort, listSortOption, 250, -5);
	moveListOption.className = "popup popup-move hide";
	listSortOption.className = "popup popup-sort";
});

function sortListCard(listId, type) {
	let listCard = getList(listId).children[1];
	let numberOfCard = listCard.childElementCount;
	switch (type) {
		case 1:
			for (let i = 0; i < numberOfCard - 1; i++) {
				for (let j = i + 1; j < numberOfCard; j++) {
					if (listCard.children[i].getAttribute('data-deadline') < listCard.children[j].getAttribute('data-deadline')) {
						listCard.insertBefore(listCard.children[j], listCard.children[i]);
					}
				}
			}
			break;
		case 2:
			for (let i = 0; i < numberOfCard - 1; i++) {
				for (let j = i + 1; j < numberOfCard; j++) {
					if (listCard.children[i].getAttribute('data-deadline') > listCard.children[j].getAttribute('data-deadline')) {
						listCard.insertBefore(listCard.children[j], listCard.children[i]);
					}
				}
			}
			break;
		case 3:
			for (let i = 0; i < numberOfCard - 1; i++) {
				for (let j = i + 1; j < numberOfCard; j++) {
					if (listCard.children[i].getAttribute('data-title') > listCard.children[j].getAttribute('data-title')) {
						listCard.insertBefore(listCard.children[j], listCard.children[i]);
					}
				}
			}
			break;
	}
}

sortByDeadlineDown.addEventListener('click', function () {
	let listId = document.getElementById('list-control').getAttribute('data-id-list');
	sortListCard(listId, 1);
});

sortByDeadlineUp.addEventListener('click', function () {
	let listId = document.getElementById('list-control').getAttribute('data-id-list');
	sortListCard(listId, 2);
});

sortByName.addEventListener('click', function () {
	let listId = document.getElementById('list-control').getAttribute('data-id-list');
	sortListCard(listId, 3);
});

let moveListOption = document.getElementById('list-move-option');
let moveIndex = document.getElementById('select-option');
let saveIndex = document.getElementById('save-index');

listMove.addEventListener('click', function () {
	setPosition(listMove, moveListOption, 250, -5);
	moveListOption.className = "popup popup-move";
	listSortOption.className = "popup popup-sort hide";
	loadIndex();
});

function loadIndex() {
	moveIndex.innerHTML = "";
	let numberOfList = document.getElementById('board-content').childElementCount - 1;
	let listIndex = document.getElementById('list-control').getAttribute('data-index');
	for (let i = 1; i <= numberOfList; i++) {
		let opt = document.createElement('option');
		opt.value = i;
		if (i == listIndex) {
			opt.text = i + " (current)";
			opt.selected = true;
		} else {
			opt.text = i;
		}
		moveIndex.appendChild(opt);
	}
}

function moveList(firstIndex, secondIndex) {
	let boardContent = document.getElementById('board-content');
	let firstListWrapper = getListWrapper(firstIndex);
	let secondListWrapper = getListWrapper(secondIndex);
	let latchWrapper = firstListWrapper.nextElementSibling;

	let firstList = firstListWrapper.firstElementChild;
	let secondList = secondListWrapper.firstElementChild;
 
	let latchIndex = firstList.getAttribute('data-index');
	firstList.setAttribute('data-index', secondList.getAttribute('data-index'));
	secondList.setAttribute('data-index', latchIndex);

	if(secondListWrapper != latchWrapper) {
		boardContent.insertBefore(firstListWrapper, secondListWrapper);
		boardContent.insertBefore(secondListWrapper, latchWrapper);
	} else {
		boardContent.insertBefore(secondListWrapper, firstListWrapper);
	}

	let numberCardOfFirst = firstList.children[1].childElementCount;
	let numberCardOfSecond = secondList.children[1].childElementCount;

	for(let i = 0; i< numberCardOfFirst;i++) {
		let card = firstList.children[1].children[i];
		let url = setURLCard(card.getAttribute('data-id-board'), card.getAttribute('data-id-list'), card.getAttribute('data-id-card'));
		handleAPI(url, setTokenToData("lists_id", secondList.getAttribute('data-id-list')), "PUT", "card");
		card.setAttribute('data-id-list', secondList.getAttribute('data-id-list'));
	}

	for(let i = 0 ;i<numberCardOfSecond;i++) {
		let card = secondList.children[1].children[i];
		let url = setURLCard(card.getAttribute('data-id-board'), card.getAttribute('data-id-list'), card.getAttribute('data-id-card'));
		handleAPI(url, setTokenToData("lists_id", firstList.getAttribute('data-id-list')), "PUT", "card");
		card.setAttribute('data-id-list', firstList.getAttribute('data-id-list'));
	}
	
	let latchUrl = "/boards/" + firstList.getAttribute('data-id-board') + "/lists/" + firstList.getAttribute('data-id-list');
	handleAPI(latchUrl, setTokenToData("id", "2000"), "PUT", "list");

	let secondUrl = "/boards/" + secondList.getAttribute('data-id-board') + "/lists/" + secondList.getAttribute('data-id-list');
	handleAPI(secondUrl, setTokenToData("id", firstList.getAttribute('data-id-list')), "PUT", "list");

	let firstUrl = "/boards/" + firstList.getAttribute('data-id-board') + "/lists/2000";
	handleAPI(firstUrl, setTokenToData("id", secondList.getAttribute('data-id-list')), "PUT", "list");

	let latchId = firstList.getAttribute('data-id-list');
	firstList.setAttribute('data-id-list', secondList.getAttribute('data-id-list'));
	secondList.setAttribute('data-id-list', latchId);
}

saveIndex.addEventListener('click', function() {
	let listControl = document.getElementById('list-control');
	let current = listControl.getAttribute('data-index');
	let choice = moveIndex.value;
	if(choice != current) {
		console.log(choice);
		moveList(current, choice);
		moveListOption.className = "popup popup-move hide";
		listControl.className = "popup list-control hide";
	}
});
