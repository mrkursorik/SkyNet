ïààà
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
c("button1")->caption = '?aaioa?...';
$s_status_mode = c("simple_status")->checked;
$repeat = c("repeat")->text;
if (c("troll")->checked) {
$troll_mode = true;
} else {
$troll_mode = false;
}
if ($repeat > 30) {
c("label9")->caption .= 'Au aua?aee aieuoia eiee-ai oeeeia!!! I?ia?aiia ii?ao caaenioou!  O?iaaou aa ia io?ii! Yoi iniaaiiinou!';
}
if (c("stop_bot")->checked){
if (c("online")->checked || c("status")->checked) {
} else {
messageDlg("Ia aua?aii ieiaiie ooieoee! Aaeuiaeoay ?aaioa ia aicii?ia!", mtError, MB_OK);
c("repeat")->text = '0';
}
}
for ( $i=0; $i<=c("repeat")->text; $i++) {

if (5 == rand(1,8)){ //Caueoa io ?anouo cai?inia!
if ( c("smart_ava")->checked){ //Oiiay aaaoa?ea
file_get_contents('https://api.vk.com/method/xxxxxx?&access_token='.$access_token);
c("memo1")->text .= "Aaaoa? iaiiaeai...!\n";
c("memo1")->repaint();
}
if ( c("online")->checked){ //Aa?iue iieaei)))
file_get_contents('https://api.vk.com/method/account.setOnline?&access_token='.$access_token);
c("memo1")->text .= "Iaiiaeaiea iieaeia caaa?oaii...!\n";
c("memo1")->repaint();
}
if (c("status")->checked){ //Aaoinoaoon)))
if (c("test_status")->checked){ //Oanoiaue AaoiNoaoon
$i2 = date("l%20dS%20of%20F%20Y%20h:i:s%20A").'|%20SkyNet%20Powered!%20:)%20|'.rand(1,60);
}

//I?iaa?ea ia aua?aiiua ooieoee noaoona!
if (c("simple_status")->checked){
if (c("test_status")->checked || c("messages")->checked || c("weather")->checked || c("friendsadd")->checked || c("citates")->checked || c("datetime")->checked){
} else {
messageDlg("Ia aua?aii ieiaiie ooieoee Aaoinoaoona! Aaeuiaeoay ?aaioa ia aicii?ia!", mtError, MB_OK);
c("repeat")->text = '0';
}
}
if (c("simple_status")->checked){ //i?iaa?ea ia i?inoie ?a?ei..
c("statuses->status_manually")->enabled = false;
if (c("message")->checked){$i = '| ooieoey |'; } //Ooieoey iieaca eiee-ai niiauaiee!
if (c("citates")->checked){
$citates_file=file('citates.txt');
$i1 = $citates_file[rand(0,count($citates_file)-1)];
$status_text = $i1.$i; //No?iea noaoona!
}
} else {
c("statuses->status_manually")->enabled = true;
$texxxt = c("statuses->status_manually")->text;

$file_citates =file('citates.txt');
$string_citates  = $file_citates [rand(0,count($file_citates)-1)];

$function_tags = array ("%<time>%" => "[a?aiy]","%<messages>%" => "[eiee-ai niiauaiee]" , "%<timevk>%" => "[aic?ano no?aieou ae]","%<about>%" => "[SkyNet Engine Alfa 0.1]","%<citates>%" => $string_citates); //caaaai oaae
echo var_dump($citates);
$status_text = preg_replace(array_keys($function_tags), array_values($function_tags), $texxxt);
}
$main_text = preg_replace(' ', '%20', $status_text);
file_get_contents('https://api.vk.com/method/status.set?text='.$main_text.'&access_token='.$access_token);
}
}




if (c("stop_bot")->checked){ //I?iaa?ea ia aii. ooieoee!
c("memo1")->text .= "Iaiiaeaiea eioi?iaoee...!\n";
c("memo1")->repaint();
} else {
$messagesGet = file_get_contents('https://api.vk.com/method/messages.getDialogs?count='.c("potoki")->text.'&preview_length=12&unread=1&v=5.14&access_token='.$access_token);
$jsonM = json_decode($messagesGet,1);
$countMess = count($jsonM['response'][items]);
//c("potoki")->text = $countMess; //?aeiiaiaiaaiiia eiee-ai iioieia ia iniiaa eie-aa iai?i?eoaiiuo niiauaiee!
c("memo1")->text .= "Au?eneee ?aeiiaiaiaaiiia eiee-ai iioieia: ".$countMess."!\n";
c("memo1")->repaint();
for ( $i=0; $i<=$countMess; $i++) {
//for ( $i=0; $i<=c("potoki")->text; $i++) {
$sms = $jsonM[response][items][$i][message][body];
$id_user = $jsonM[response][items][$i][message][user_id];
$messages_users = iconv("utf-8", "windows-1251", $sms);
if ($messages_users != null){ //Anee niiauaiea ia ionoi (aac niaeeia e oa. oieuei oaeno)
if ($troll_mode == true){//A?oaaai "O?ieu-iia" LOL
//echo $txt[ array_rand(file('troll.txt')) ];
$troll_file=file('troll.txt');
$texxt1 = $troll_file[rand(0,count($troll_file)-1)];
$texxt6 = preg_replace(' ', '%20', $texxt1);
//$texxt = iconv ('windows-1251', 'utf-8', $texxt1);
} else {
//?a?ei iieiioaiiiai aioa!
echo "bot active";
}
$s_message = file_get_contents('https://api.vk.com/method/messages.send?user_id='.$id_user.'&message='.$texxt6.'&access_token='.$access_token);
if ($s_message == false) {
if(messageDlg("Iioa?yii niaaeiaiea n eioa?iaoii!!!", mtError, MB_OK) == true){
c("repeat")->text = '0';
c("potoki")->text = '0';
}
}
c("memo1")->text .= "Ioaaoeee iieuciaaoae? n id".$id_user."\n";
c("memo1")->repaint();
}
sleep(1);
}
}
sleep(c("timeout")->text); //Iacia?aai oaeiaoo!
c("repeat")->enabled = true;
c("potoki")->enabled = true;
c("timeout")->enabled = true;
c("button1")->enabled = true;
c("button1")->caption = 'Noa?o';
c("label9")->enabled = false;
}