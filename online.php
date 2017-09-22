<?

$sql = "SELECT user_id, username, premiumaccount, admin, online, buddy, blocklist,ismobile FROM gebruikers WHERE online+'1000'>'" . time() . "' ORDER BY rank DESC, rankexp DESC, username ASC";

$expire = 1;
$records = query_cache("online", $sql, $expire);
$aantal = count($records);
$teller = 0;
#Beeld weergave
?>
<p>
<h3>
    <?php
    if ($aantal > 0) echo $txt[''] . $txt['online_users'].' (' . $aantal . '):';
    else echo $txt['nobody_online']; ?>
</h3><br/>
<?
if ($aantal > 0) {
    foreach ($records as $id => $online) {
        $fixt = ',' . $online['user_id'] . ',';

        //Bij elk lid bij de teller 1 op tellen
        $teller++;
        //Name dik gedrukt maken als de online speler een admin is
        if ($online['admin'] == 0) {
            $type = "User";
            $color = "black";
            $img = "images/icons/user.png";
        }
        elseif ($online['admin'] == 1) {
            $type = "Moderator";
            $color = "blue";
            $img = "images/icons/user_mod.png";
        }
        elseif ($online['admin'] == 2) {
            $type = "Administrator";
            $color = "purple";
            $img = "images/icons/user_suit.png";
        }
        elseif ($online['admin'] == 3) {
            $type = "Eigenaar";
            $color = "red";
            $img = "images/icons/user_admin.png";
        } else {
            $type = "User";
            $color = "black";
            $img = "images/icons/user.png";
        }

        //Premiumaccount check, true = ster
        if (($online['premiumaccount'] > 0) && ($online['admin'] == 0)) {
            $star = '<img src="images/icons/lidbetaald.png" width="16" height="16" border="0" alt="Premiumlid" title="Premiumlid" style="margin-bottom:-3px;">';
        } else {
            $star = '';
        }
        
        //is user mobile
        if ($online['ismobile']) {
            $type = "Op mobiel";
            $img = "images/icons/mobile.png";
        }
        
        if($online['username'] != $_SESSION['naam']){
            $link = "javascript:chatWith('" . $online['username'] . "')";
        }else{
            $link = "?page=profile&player=" . $online['username'];
        }

        if ($aantal == 1) {
            echo "<a href=".$link."><span style='color: ".$color.";'><b>" . $online['username'] . "</b></span> <img src='".$img."' width='16' height=16 border=0 alt='".$type."' title='".$type."' style='margin-bottom:-3px;'></a> ".$star;
        }
        elseif ($aantal > $teller) {
            echo "<a href=".$link."><span style='color: ".$color.";'><b>" . $online['username'] . "</b></span> <img src='".$img."' width='16' height=16 border=0 alt='".$type."' title='".$type."' style='margin-bottom:-3px;'></a> ".$star." | ";
        }
        else {
            echo "<a href=".$link."><span style='color: ".$color.";'><b>" . $online['username'] . "</b></span> <img src='".$img."' width='16' height=16 border=0 alt='".$type."' title='".$type."' style='margin-bottom:-3px;'></a> ".$star;
        }
    }
}
?>
<hr>
<br/>
<b><span style='color: Red;'><?=$txt['online_name']?></span></b> <img src="images/icons/user_admin.png" width="16" height="16" border="0"
                                                  alt="<?=$txt['online_owner']?>" title="<?=$txt['online_owner']?>" style="margin-bottom:-3px;"> = <?=$txt['online_owner']?> ||
<b><span
        style='color: blue;'><?=$txt['online_name']?></span></b> <img src="images/icons/user_mod.png" width="16" height="16" border="0"
                                                  alt="<?=$txt['online_mod']?>" title="<?=$txt['online_mod']?>"
                                                  style="margin-bottom:-3px;"> = <?=$txt['online_mod']?> || <b><span
        style='color: Black;'><?=$txt['online_name']?></span></b> <img src="images/icons/user.png" width="16" height="16" border="0"
                                                   alt="<?=$txt['online_mod']?>" title="<?=$txt['online_mod']?>" style="margin-bottom:-3px;"> = <?=$txt['online_mod']?> || <b><span
        style='color: dimgrey;'><?=$txt['online_name']?></span></b> <img src="images/icons/mobile.png" width="16" height="16" border="0"
                                                   alt="<?=$txt['online_mobile']?>" title="<?=$txt['online_mobile']?>" style="margin-bottom:-3px;"> = <?=$txt['online_mobile']?> <a
    href="?page=rankinglist" style='float:right;'><img src="images/icons/all.png" width="16"
                                                                            height="16" border="0" alt="<?=$txt['online_members']?>"
                                                                            title="<?=$txt['online_members']?>" style="margin-bottom:-3px;">
    <?=$txt['online_members']?></a>
</p>