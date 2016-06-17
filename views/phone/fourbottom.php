<?php
use app\modules\AppBase\base\HintConst;
use app\modules\AppBase\base\SiteCom;
?>
<script type="text/javascript" src="js/bottomgb.js" ></script>
<div class="bottom_140"></div>
<div class="x_bottom_all">
<div class="bottom_top"><a href=<?php echo SiteCom::$phone_url."classmessage" ?> onClick="changeimg6()" class="bottom_top_left"> <img src="images/class_info_0.png" border="0" id="06"></a> <a href="tel:<?= Yii::$app->session['phone'] ?>" class="bottom_top_right" ><img src="images/call_phone_0.png"> </a></div>
<div class="bottom_bottom"><ul id="box"><li id="1"   ><a  onClick="changeimg1()"  href=<?php echo SiteCom::$phone_url."index_all" ?> target="_self"><img id="01" src="images/today_smy_0.png"><br>今日总结</a></li>
<li id="2"  ><a  onClick="changeimg2()"  href=<?php echo SiteCom::$phone_url."amail" ?> target="_self"><img id="02" src="images/garden_msg_0.png"><br>
  园所信箱</a></li>
<li id="3"  ><a  onClick="changeimg3()" href=<?php echo SiteCom::$phone_url."newcont" ?> target="_self"><img id="03" src="images/new_article_0.png"><br>
  新文章</a></li>
<li  id="4"  ><a  onClick="changeimg4()" href=<?php echo SiteCom::$phone_url."grow" ?> target="_self"><img id="04" src="images/growth_0.png"><br>
  成长历程</a></li>
<li id="5" ><a  onClick="changeimg5()" href=<?php echo SiteCom::$phone_url."mymessage" ?> target="_self"><img id="05" src="images/user_info_0.png"><br>
  我的信息</a></li>
</ul>
<br style="clear:both;">
</div>
</div>