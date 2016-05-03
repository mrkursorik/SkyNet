//echo c("statuses->status_manually")->text;

$repeat = c("repeat")->text;
$threads = c("potoki")->text;
$timeout = c("timeout")->text;
ini::open("config.ini");
ini::write("main_config", "repeat", "'$repeat'");
ini::write("main_config", "threads", "'$threads'");
ini::write("main_config", "timeout", "'$timeout'");

$ini_read = parse_ini_file('config.ini', true);
$access_token = $ini_read['main_config']['access_token'];
c("repeat")->enabled = false;
c("potoki")->enabled = false;
c("timeout")->enabled = false;
c("button1")->enabled = false;
c("button1")->caption = 'Работаю...';
$s_status_mode = c("simple_status")->checked;
$repeat = c("repeat")->text;
if (c("troll")->checked) {
$troll_mode = true;
} else {
$troll_mode = false;
}
if ($repeat > 30) {
c("label9")->caption .= 'Вы выбрали большое колл-во циклов!!! Программа может зависнуть!  Трогать ее не нужно! Это особенность!';
}
if (c("stop_bot")->checked){
if (c("online")->checked || c("status")->checked) {
} else {
messageDlg("Не выбрано ниодной функции! Дальнейшая работа не возможна!", mtError, MB_OK);
c("repeat")->text = '0';
}
}
for ( $i=0; $i<=c("repeat")->text; $i++) {

if (5 == rand(1,8)){ //Защита от частых запросов!
if ( c("smart_ava")->checked){ //Умная аватарка
file_get_contents('https://api.vk.com/method/xxxxxx?&access_token='.$access_token);
c("memo1")->text .= "Аватар обновлен...!\n";
c("memo1")->repaint();
}
if ( c("online")->checked){ //Вечный онлайн)))
file_get_contents('https://api.vk.com/method/account.setOnline?&access_token='.$access_token);
c("memo1")->text .= "Обновление онлайна завершено...!\n";
c("memo1")->repaint();
}
if (c("status")->checked){ //Автостатус)))
if (c("test_status")->checked){ //Тестовый АвтоСтатус
$i2 = date("l%20dS%20of%20F%20Y%20h:i:s%20A").'|%20SkyNet%20Powered!%20:)%20|'.rand(1,60);
}

//Проверка на выбранные функции статуса!
if (c("simple_status")->checked){
if (c("test_status")->checked || c("messages")->checked || c("weather")->checked || c("friendsadd")->checked || c("citates")->checked || c("datetime")->checked){
} else {
messageDlg("Не выбрано ниодной функции Автостатуса! Дальнейшая работа не возможна!", mtError, MB_OK);
c("repeat")->text = '0';
}
}
if (c("simple_status")->checked){ //проверка на простой режим..
c("statuses->status_manually")->enabled = false;
if (c("message")->checked){$i = '| функция |'; } //Функция показа колл-во сообщений!
if (c("citates")->checked){
$citates_file=file('citates.txt');
$i1 = $citates_file[rand(0,count($citates_file)-1)];
$status_text = $i1.$i; //Строка статуса!
}
} else {
c("statuses->status_manually")->enabled = true;
$texxxt = c("statuses->status_manually")->text;

$file_citates =file('citates.txt');
$string_citates  = $file_citates [rand(0,count($file_citates)-1)];

$function_tags = array ("%<time>%" => "[время]","%<messages>%" => "[колл-во сообщений]" , "%<timevk>%" => "[возраст страницы вк]","%<about>%" => "[SkyNet Engine Alfa 0.1]","%<citates>%" => $string_citates); //задаем теги
echo var_dump($citates);
$status_text = preg_replace(array_keys($function_tags), array_values($function_tags), $texxxt);
}
$main_text = preg_replace(' ', '%20', $status_text);
file_get_contents('https://api.vk.com/method/status.set?text='.$main_text.'&access_token='.$access_token);
}
}




if (c("stop_bot")->checked){ //Проверка на доп. функции!
c("memo1")->text .= "Обновление информации...!\n";
c("memo1")->repaint();
} else {
$messagesGet = file_get_contents('https://api.vk.com/method/messages.getDialogs?count='.c("potoki")->text.'&preview_length=12&unread=1&v=5.14&access_token='.$access_token);
$jsonM = json_decode($messagesGet,1);
$countMess = count($jsonM['response'][items]);
//c("potoki")->text = $countMess; //Рекомендованное колл-во потоков на основе кол-ва непрочитанных сообщений!
c("memo1")->text .= "Вычислил рекомендованное колл-во потоков: ".$countMess."!\n";
c("memo1")->repaint();
for ( $i=0; $i<=$countMess; $i++) {
//for ( $i=0; $i<=c("potoki")->text; $i++) {
$sms = $jsonM[response][items][$i][message][body];
$id_user = $jsonM[response][items][$i][message][user_id];
$messages_users = iconv("utf-8", "windows-1251", $sms);
if ($messages_users != null){ //Если сообщение не пусто (без смайлов и тд. только текст)
if ($troll_mode == true){//Врубаем "Троль-мод" LOL
//echo $txt[ array_rand(file('troll.txt')) ];
$troll_file=file('troll.txt');
$texxt1 = $troll_file[rand(0,count($troll_file)-1)];
$texxt6 = preg_replace(' ', '%20', $texxt1);
//$texxt = iconv ('windows-1251', 'utf-8', $texxt1);
} else {
//Режим полноценного бота!
echo "bot active";
}
$s_message = file_get_contents('https://api.vk.com/method/messages.send?user_id='.$id_user.'&message='.$texxt6.'&access_token='.$access_token);
if ($s_message == false) {
if(messageDlg("Потеряно соединение с интернетом!!!", mtError, MB_OK) == true){
c("repeat")->text = '0';
c("potoki")->text = '0';
}
}
c("memo1")->text .= "Ответили пользователю с id".$id_user."\n";
c("memo1")->repaint();
}
sleep(1);
}
}
sleep(c("timeout")->text); //Назначаем таймаут!
c("repeat")->enabled = true;
c("potoki")->enabled = true;
c("timeout")->enabled = true;
c("button1")->enabled = true;
c("button1")->caption = 'Старт';
c("label9")->enabled = false;
}