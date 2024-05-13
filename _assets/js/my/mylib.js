/*
	Функция для установки файла cookie
	----- ----- -----
	Параметрами функции выше являются имя файла cookie (CNAME), значение файла cookie (квалуе) и количество дней до истечения срока действия файла cookie (ексдайс).
	Функция задает файл cookie, добавляя вместе кукиенаме, значение cookie и строку истечения срока действия.
*/
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000)); // в сутках
//     d.setTime(d.getTime() + (86400000)); // 1 сутки (в мсек)
//     d.setTime(d.getTime() + (259200000)); // 3 суток (в мсек)
//     d.setTime(d.getTime() + (604800000)); // 1 Неделя (в мсек)
//     d.setTime(d.getTime() + (60000)); // 1 секунда (в мсек)
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


/*
	Функция для получения файла cookie
	----- ----- -----
	Возьмите кукиенаме как параметр (CNAME).
	Создайте переменную (Name) с искомым текстом (CNAME + "=").
	Расшифровка строки cookie для обработки файлов cookie со специальными символами, например ' $ '
	Разделите Document. cookie на точки с запятой в массив с именем CA (CA = декодедкукие. Split ('; ')).
	Цикл через массив ЦС (i = 0; i <CA. Длина; i + +) и считывание каждого значения c = CA [i]).
	Если файл cookie найден (c. IndexOf (Name) = = 0), верните значение файла cookie (c. подстрока (Name. length, c. length).
	Если файл cookie не найден, вернитесь "".
*/
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


/*
	Функция для получения файла cookie
	----- ----- -----
	Наконец, мы создаем функцию, которая проверяет, установлен ли файл cookie.
	Если файл cookie установлен, он отобразит приветствие.
	Если файл cookie не установлен, отобразится окно приглашения, запрашивающее имя пользователя, и хранит имя пользователя cookie в течение 365 дней, вызвав функцию setCookie
*/
function checkCookie(tmp) {
		var username = getCookie("username");
		if (username != "") {
// 			alert("Welcome again " + username);
			return 0;
		}
		else {
// 			username = prompt("Please enter your name:", "");
			username = tmp;
			if (username != "" && username != null) { setCookie("username", username, 3); }
			return 1;
		}
}


/*
	Функция для получения push-уведомлений
	----- ----- -----
*/

function notifyMe() {
  // Давайте проверим, поддерживает ли браузер уведомления
  if (!("Notification" in window)) {
    alert("Ваш браузер не поддерживает HTML5 Notifications");
  }
  // Теперь давайте проверим есть ли у нас разрешение для отображения уведомления
  else if (Notification.permission === "granted") {
    // Если все в порядке, то создадим уведомление
    var notification = new Notification('Уведомление HTML5', {
      lang: 'ru-RU',
      body: 'Здесь какой-то контент уведомления...',
      icon: 'http://lorempixel.com/output/sports-q-c-100-100-9.jpg'
    });
  }
  // В противном случае, мы должны спросить у пользователя разрешение
  else if (Notification.permission === 'default') {
    Notification.requestPermission(function (permission) {

      // Не зависимо от ответа, сохраняем его в настройках
      if(!('permission' in Notification)) {
        Notification.permission = permission;
      }
      // Если разрешение получено, то создадим уведомление
      if (permission === "granted") {
        var notification = new Notification('Уведомление HTML5', {
         lang: 'ru-RU',
         body: 'Здесь какой-то контент уведомления...',
         icon: 'http://lorempixel.com/output/sports-q-c-100-100-9.jpg'
      });
      }
    });
  }
  else {
	  console.log("Ни фига не происходит");
  }


Notification.requestPermission().then(function(result) {
  console.log(result);
});

}

