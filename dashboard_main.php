<?php
    $dashboard_main_strings_html = file_get_contents($directory . $language . "/" . "dashboard_main_strings.php");
    
    eval(" ?> " . $dashboard_main_strings_html . " <?php ");
?>

<?php 
    include($directory . "dbuser.php");
    include($directory . "dash_utils.php");
    
    $curuser_id = $_SESSION["s_user_id"];
    
    if(ISSET($_GET["user_id"])) {
        $curuser_id = $_GET["user_id"];
    }
?>

<?php if($curuser_id) { // maybe first these vars should be initialized
     foreach ($dbuser -> readProfile($curuser_id) as $tuple) {  
        $website = $tuple['website'];
        $regdate = $tuple['date(regdate)'];
        $location = $tuple['location'];
        $birth = $tuple['birth'];
        $realname = $tuple['realname'];
        $aboutme = $tuple['aboutme'];
        $lastseen = $tuple['lastlogin'];
        $image = $tuple['image'];
        $gender = $tuple['gender'];
        $email = $tuple['email'];
     }
} ?>

<div id="dashcontent" class="hr">
     <h1 id="user-displayname"><label class="username"><?php
                if($_SESSION["s_username"]) { echo $_SESSION["s_username"]; } ?></label></h1>
     <div class="sub-header-links">
        <span class="editusername"><?php echo LANG_EDIT; ?></span>
        <a><?php if($curuser_id) {?><a href="<?php print($directory); ?>logout.php" title="Logout"><?php echo LANG_LOGOUT; } ?></a>
        <span class="usernamenotsaved"></span>
        <span class="usernamesaved"><?php echo LANG_SAVED; ?></span>
        <span class="usernamewarn"><?php echo LANG_SAVED; ?></span>
     </div>
     <hr/>
     
     <div id="content" class="container_16 clearfix">
        <div class="grid">
            <div class="box">
                <h2><?php echo LANG_PROFILE; ?></h2>
                <div class="utils utils2">
                    <span class="profilesaved"><?php echo LANG_SAVED; ?></span>
                </div>
                <div class="utils utils2">
                    <span class="profilenotsaved"></span>
                </div>
                <div class="utils utils2">
                    <span class="profilewarn"></span>
                </div>
                <div class="utils">
                    <span class="editprofile"><?php echo LANG_EDIT; ?><img src="<?php print($directory); ?>/gcr/images/dash/profile.svg"></span>
                </div>
                <div class="imgs">
                    <img class="genderzone" src="<?php print $directory;
                         if ($image && file_exists($image)) {
                            print'/gcr/user_images/' . basename($image);
                         } else {
                            print '/gcr/user_images/noimage.jpg';
                         }
                    
                    ?>">
                    
                    
                    <div class="genderzone chpic" style="display: none; position: absolute;">
                       <img src="<?php print($directory); ?>/gcr/images/dash/changepic.png" style="left: 14px; height: 25px; bottom: 6px; position:absolute; height: 25px; "/>
                       <label class="lblchpic" style="position:absolute; width: 100px; left: 20px; bottom: 9px; color: white; cursor: pointer;">change picture</label>
                    </div>
                    <p class="gender">
                        <img class="genderimage" src="<?php print($directory);
                                 if ($gender) {
                                    print '/gcr/images/dash/' . $gender . '.svg';
                                 } else {
                                    print '/gcr/images/dash/nogender.svg';
                                 }
                            ?>">
                        <!-- <input type="text" style="position: absolute; left: 20px; bottom: 40px; width: 50px;"/> -->
                        <!-- <form action=""> -->
                            <fieldset class="genderchoose">
                                <input id="gender-female" type="checkbox" class="dash-checkbox female" <?php print $gender == 'F' ? 'checked="checked"' : ''?> name="gender"/>
                                <label for="gender-female" class="dash-checkbox-label">Female</label>
                                <input id="gender-male" type="checkbox" class="dash-checkbox male" <?php print $gender == 'M' ? 'checked="checked"' : ''?> name="gender"/>
                                <label for="gender-male" class="dash-checkbox-label">Male</label>
                            </fieldset>
                        <!-- </form> -->
                    </p>
                </div>

                <p>
                    <table>
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td><em>Bio</em></td><td><strong><?php echo LANG_WEBSITE; ?></strong></td>
                                <td><label class="website" onclick="location.href='<?php echo 'http://' . $website; ?>'"><?php echo $website; ?></label></td>
                            </tr>
                            <tr>
                                <td></td><td><strong><?php echo LANG_LOCATION; ?></strong></td> <td><label class="location"><?php echo $location; ?></label></td>
                            </tr>
                            <tr>
                                <td></td><td><strong><label class="agebirth"><?php echo LANG_AGE; ?></label></strong></td>
                                 <td><label class="age"><?php if ($birth) { echo floor((time() - strtotime($birth)) / 31556926); }
                                    else echo ''; ?></label></td>
                            </tr>
                            <tr>
                                <td><em>Visit</em></td><td><strong><?php echo LANG_MEMBERFOR; ?></strong></td>
                                <td>
                                    <?php
                                        echo memberFor($regdate);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td><td><strong><?php echo LANG_SEEN; ?></strong></td>
                                <td>
                                    <?php
                                        echo lastSeen($lastseen);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td><em>Stats</em></td><td><strong><?php echo LANG_PROFILEVIEWS; ?></strong></td>
                                <td>
                                    . . .
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                            <tr>
                                <td><em>Private</em></td><td><strong><?php echo LANG_REALNAME; ?></strong></td> <td><label class="realname"><?php echo $realname; ?></label></td>
                            </tr>
                            <tr>
                                <td></td><td><strong>email</strong></td>
                                <td>
                                    <?php echo $email; ?>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </p>
            </div>
            <div class="box">
                <h2><?php echo LANG_ABOUTME; ?></h2>
                <div class="utils utils2">
                    <span class="aboutmesaved"><?php echo LANG_SAVED; ?></span>
                </div>
                <div class="utils utils2">
                    <span class="aboutmenotsaved"></span>
                </div>
                <div class="utils utils2">
                    <span class="aboutmewarn"></span>
                </div>
                <div class="utils">
                    <span class="editaboutme"><?php echo LANG_EDIT; ?><img src="<?php print($directory); ?>/gcr/images/dash/description.svg"></span>
                </div>
                <p>
                    <form action="#" method="post">
                        <p>
                            <textarea class="aboutme" id="styled" name="post" onfocus="this.blur()" readonly="readonly"><?php echo $aboutme; ?></textarea>
                        </p>
                    </form>
                </p>
            </div>
            <!-- <div class="box">
                <h2><?php echo LANG_STATISTICS; ?></h2>
                <div class="utils">
                    <span><a href="">show more</a><img src="<?php print($directory); ?>images/dash/bars.svg"></span>
                </div>
                <p>
                    <table>
                        <tbody>
                            <tr>
                                <td><em>Data</em></td><td><strong>walking routes covered: </strong></td> <td>12<td>
                            </tr>
                            <tr>
                                <td></td><td><strong>max altitude gap: </strong></td> <td>123 m<td>
                            </tr>
                            <tr>
                                <td></td><td><strong>total distance covered: </strong></td> <td>35.85 km<td>
                            </tr>
                        </tbody>
                    </table>
                </p>
            </div> -->
            <div>
                <div class="box left-box">
                    <h2>Plot Distance</h2>
                    <div class="utils">
                        <span class="showhide-chart-total-distance"><img src="<?php print($directory); ?>/gcr/images/dash/stats.svg"></span>
                    </div>
                    <p>
                        <div id="chart-total-distance"></div>
                    </p>
                </div>
                <div class="box right-box">
                    <h2>Plot Speed</h2>
                    <div class="utils">
                        <span class="showhide-chart-average-speed"><img src="<?php print($directory); ?>/gcr/images/dash/stats.svg"></span>
                    </div>
                    <p>
                        <div id="chart-average-speed"></div>
                    </p>
                </div>
            </div>
        </div>
        <!-- <div class="grid_6">
            <div class="box">
                <h2>Description</h2>
                <div class="utils">
                    <span><img src="images/dash/description.svg"></span>
                </div>
                <p>
                    <form action="#" method="post">
                        <p>
                            <textarea id="styled" name="post" onfocus="this.blur()" readonly="readonly">I am a Software/Web Developer and an Oracle Database Administrator!
                            </textarea>
                        </p>
                    </form>
                </p>
            </div>
        </div> -->
     </div>
</div>

<div id="dialog" title="Upload a new image..">
  <p>
      <ul>
          <li>Cannot be larger than <strong>1MB</strong></li>
          <li>Must have a resolution of <strong>128x128</strong></li>
          <li>The format have to be one of the following: <strong>PNG, JPG, GIF</strong></li>
      </ul>
  </p>
  <form action="image_uploader.php" method="POST" enctype="multipart/form-data" name="uploadImForm">
      <p>
        From you computer: <input class="broPopup" type="file" id="userim" name="userim"></input>
      </p>
      <p>
        From the web: <input class="txPopup" type="text"></input>
      </p>
      <p>
        <input class="btPopup" type="submit" value="Upload" name="btPopup"></input>
      </p>
  </form>
</div>

<script type="text/javascript" src="<?php print($directory); ?>/gcr/js/dash.js"></script>
<script type="text/javascript" src="<?php print($directory); ?>/gcr/js/dash_plots.js"></script>









