  
 <span class="style2">Buddy ChatBox</span>
<!-- <p> You can use this chartbox to communicate with each other </p> -->
<div id="box">
  
  <div id="chat">

<div id="scrollArea">
<div id="scroller">
</div>
</div>

<div id="container">
<div id='content'>
</div>
</div>

<div id='form'>
<form id='cform' name='chatform' action="#" >
<div id='field_set'>
<input type='hidden' id='token' name='token' value='<?php echo $token; ?>' />
<input type='hidden' id='name' name='name' value='<?php echo $namebuddy; ?>' />
<input type='hidden' id='url' name='url' value='mailto:<?php echo $emailbuddy; ?>' />
<textarea rows='4' cols='10' id='message'  name='message' >message</textarea>
</div>
</form>
</div> 

<div id="chat_menu">

<div id ="supprmess">
<p>
<!-- You may not remove the copyright link, but you may edit its look and location on your web page -->
delete
</p>
</div>

<div id='refresh'>
<p>refresh</p>
</div>

<div id='emo'>
<ul id="show_sm">
<li>
smileys
<ul id="smiley_box">
<li>
<img class='smileys' src='wtag/smileys/smile.gif' width='15' height='15' alt=':)' title=':)' onclick = "tagSmiley(':)');" />
</li>
<li>
<img class='smileys' src='wtag/smileys/sad.gif' width='15' height='15' alt=':(' title=':(' onclick = "tagSmiley(':(');" />
</li>
<li>
<img class='smileys' src='wtag/smileys/wink.gif' width='15' height='15' alt=';)' title=';)' onclick = "tagSmiley(';)');" />
</li>
<li>
<img class='smileys' src='wtag/smileys/tongue.gif' width='15' height='15' alt=':-P' title=':-P' onclick = "tagSmiley(':-P');"/>
</li>
<li>
<img class='smileys' src='wtag/smileys/rolleyes.gif' width='15' height='15' alt='S-)' title='S-)' onclick = "tagSmiley('S-)');"/>
</li>
<li>
<img class='smileys' src='wtag/smileys/angry.gif' width='15' height='15' alt='>(' title='>(' onclick = "tagSmiley('>(');" />
</li>
<li>
<img class='smileys' src='wtag/smileys/embarassed.gif' width='15' height='15' alt=':*)' title=':*)' onclick = "tagSmiley(':*)');" />
</li>
<li>
<img class='smileys' src='wtag/smileys/grin.gif' width='15' height='15' alt=':-D' title=':-D' onclick = "tagSmiley(':-D');" />
</li>
<li>
<img class='smileys' src='wtag/smileys/cry.gif' width='15' height='15' alt='QQ' title='QQ' onclick = "tagSmiley('QQ');" />
</li>
<li>
<img class='smileys' src='wtag/smileys/shocked.gif' width='15' height='15' alt='=O' title='=O' onclick = "tagSmiley('=O');" />
</li>
<li>
<img class='smileys' src='wtag/smileys/undecided.gif' width='15' height='15' alt='=/' title='=/' onclick = "tagSmiley('=/');" />
</li>
<li>
<img class='smileys' src='wtag/smileys/cool.gif' width='15' height='15' alt='8-)' title='8-)' onclick = "tagSmiley('8-)');" />
</li>
<li>
<img class='smileys' src='wtag/smileys/sealedlips.gif' width='15' height='15' alt=':-X' title=':-X' onclick = "tagSmiley(':-X');" />
</li>
<li>
<img class='smileys' src='wtag/smileys/angel.gif' width='15' height='15' alt='O:]' title='O:]' onclick = "tagSmiley('O:]');" />
</li>
</ul>
</li>

</ul>
</div>

<div id='submit'>
<p>submit</p>
</div>

</div>

</div>
</div>
<!-- 3. Shoutbox code end -->