<?php
    require("lock.php");
	require("library/config.php");
?>
<!DOCTYPE html>
<html class=''>
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>PrintPractic</title>
      <meta name="robots" content="noindex">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="" crossorigin="anonymous">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <link href="css/spectrum.css" type="text/css" rel="stylesheet">
      <link href="css/bootstrap-slider.css" type="text/css" rel="stylesheet">
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/dd.css">
      <link rel="stylesheet" href="css/cropper.min.css">
   </head>
  <style>
  <?php
        $query = "SELECT * FROM font_file";
        $runQuery = mysql_query($query);
        if(mysql_num_rows($runQuery) > 0)
        {
            while($row = mysql_fetch_array($runQuery))
            { 

            $new_filename = str_replace("_"," ",$row['ff_name']);

             ?>
                @font-face {
                    font-family: "<?php echo $new_filename;?>";
                    src: url("<?php echo $row['ff_path'];?>");
                    font-style: normal;
                    font-weight: 400;
                }        
     <?php  }
        } 
    ?>    
    @font-face {
      font-family: 'Open Sans';
      src: url('./css/fonts/Open-Sans/OpenSans-Regular.ttf') format('truetype');
      font-weight: 400;
      font-style: normal;
    }
    /* This only works with JavaScript, 
    if it's not present, don't show loader 
    http://smallenvelop.com/display-loading-icon-page-loads-completely/
    */
    .no-js #loader { display: none;  }
    .js #loader { display: block; position: absolute; left: 100px; top: 0; }
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url(images/Preloader_3.gif) center no-repeat #fff;
    }

    /*http://stackoverflow.com/questions/35201566/overflow-y-scroll-not-showing-scrollbar-in-chrome*/
    ::-webkit-scrollbar {
        -webkit-appearance: none;
        width: 7px;
    }
    ::-webkit-scrollbar-thumb {
        border-radius: 4px;
        background-color: rgba(0,0,0,.5);
        -webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);
    }    

    #imagetocrop {
        max-width: 100%; 
    }
    #pattern_img{
        display: none;
    }
    #textpatternmenu{
        width: 100px;
        margin-left: 20px;
    }
    .dd .ddTitle .ddTitleText img {
        padding-right: 5px;
        width: 90px;
        height: 25px;
    }
    .dd .ddChild li img {
        padding: 0 6px 0 0;
        width: 90px;
        height: 25px;
    }
    .ddcommon .ddChild{
        overflow-x: hidden;
    } 
    .btn-warning.focus, .btn-warning:focus{
        color: #cebc7c;
    }
</style>
<body style="background-color:#ebecee;">
    <ul class='custom-menu'>
        <li data-action="selectall">Select All</li>
        <li data-action="cut">Cut</li>
        <li data-action="copy">Copy</li>
        <li data-action="paste">Paste</li>
    </ul>
    <!--<div id="loadingpage" class="modal" data-backdrop="static" data-keyboard="false" style="background:#87cac1; opacity:1; display:block;"><i class="fa fa-refresh fa-spin" style="position: absolute; top: 50%; left: 50%; margin-top: -75px; margin-left: -75px; font-size: 150px; color:#fff;"></i>
    </div>-->
    <div class="container" id="page-container">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <div class="logoimg" style="margin-left: 0px; margin-top: 10px;">
                                <a href='#'><img class="navbar-brand" src="images/logo.jpg" style="padding:0px;height: 45px;">
                                </a>
                            </div>
                        </li>
                    </ul>
                    <span class="navbar-right">
						<ul class="nav navbar-nav">
							<li class="dropdown" id="file-menu">
								<button class="btn btn-warning"  data-toggle="dropdown" style='background-color:transparent; border-color:transparent; margin-left: -55px;'><i class="fa fa-floppy-o fa-lg" aria-hidden="true"></i><br>Save</button>
								<ul class="dropdown-menu">
									<li><a id="savetemplateadmin" href="javascript:void(0);">Save File</a></li>
									<li><a id="saveastemplate" href="javascript:void(0);">Save As File</a></li>
								</ul>
							</li>
						</ul>
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle" style='background-color:transparent; border-color:transparent;'><i class="fa fa-download fa-lg" aria-hidden="true"></i><br>Download</button>
                            <ul class="dropdown-menu">
                              <li><a class="downloadAsPDF" href="javascript:void(0);">Save As PDF (For Print)</a></li>
                              <li><a id="downloadAsPNG" href="javascript:void(0);">Save As PNG (For Web)</a></li>
                              <li><a id="downloadAsJPEG" href="javascript:void(0);">Save As JPEG (For Web)</a></li>
                              <li><a id="downloadtemplate" href="javascript:void(0);">Save As PT</a></li>
                              <li class="divider"></li>
                              <li class="dropdown-submenu">
                              <a href="javascript:void(0);">More Options<span class="caret" style="margin-left:10px;"></a>
                              <ul class="dropdown-menu" style="width: 191px;">
                                  <li><a href="javascript:void(0);" class="noclose" data-value="option1" tabIndex="-1"><input type="checkbox" id="savecrop"/>&nbsp;Save with Crop Marks</a></li>
                              </ul>
                            </li>
                            </ul>
                        </div>

					   <button class="btn btn-warning" title="Undo" type="button" id="undo" style='background-color:transparent; border-color:transparent;'><i class="fa fa-undo fa-lg" aria-hidden="true" style=""></i><br>Undo</button>
					   <button class="btn btn-warning" title="Redo" type="button" id="redo" style='background-color:transparent; border-color:transparent;'><i class="fa fa-repeat fa-lg" aria-hidden="true"></i><br>Redo</button>
                       <button class="btn btn-warning" type="button"   onClick='javascript:newtemp("admin");' style='background-color:transparent; border-color:transparent;'><i class="fa fa-file fa-lg" aria-hidden="true"></i><br>New Template</button>
                       <button class="btn btn-warning" type="button" style='background-color:transparent; border-color:transparent;' onClick="location.href='logout.php'"><i class="fa fa-power-off fa-lg" aria-hidden="true"></i><br>Logout</button>
                    </span>
                </div>
            </div>
        </nav>

        <div class="row">
            <div id="leftsection" style="padding-right: 0px; padding-left: 0px; position:fixed;z-index:1000;">
                <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#a" data-toggle="tab"><i class="fa fa-th-large"></i></br>Templates</a>
                        </li>
                        <li><a href="#b" data-toggle="tab"><i class="fa fa-font"></i></br>Text</a>
                        </li>
                        <li><a href="#c" data-toggle="tab"><i class="fa fa-picture-o"></i></br>Elements</a>
                        </li>
                        <li><a href="#e" data-toggle="tab"><i class="fa fa-circle"></i></br>Shapes</a>
                        </li>
                        <li><a href="#d" data-toggle="tab"><i class="fa fa-th"></i></br>Bkground</a>
                        </li>
                        <li><a href="javascript:void(0);" id="upload_image"><i class="fa fa-cloud-upload"></i></br>Add image</a>
                        </li>
                        <li><a href="javascript:void(0);" id="upload_file"><i class="fa fa-file"></i></br>Font list</a></li>
                        <li><a href="#f" data-toggle="tab"><i class="fa fa-download"></i></br>Limits</a></li>
                    </ul>
                    <div class="tab-content" style="margin-left:80px; position:absolute;">
                        <div class="tab-pane active" id="a">
                            <div class="col-lg-12">
                                <div class="dropdown" style="float:left;">
                                    <button class="btn btn-default dropdown-toggle btn-menu" type="button" id="templateMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="width:35px;">
                                        <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="templateMenu">
                                        <li><a href="javascript:void(0);" id="addTemplateCategory">New Category</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="editcategory">Edit Category</a>
                                        </li>
                                        <li><a href="javascript:void(0);" onClick='javascript:location.href="index.php?newtemplate";'>New Flyer</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="deletetempcat">Delete Category</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="deleteTemp">Delete Flyer</a>
                                        </li>
                                    </ul>
                                </div>
                                <select class="form-control" name="tempcat-select" id="tempcat-select">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="" id="template_container" style="text-align:center;margin-top:40px;margin-left:20px;">
                            </div>
                        </div>
                        <div class="tab-pane" id="b">
                            <div class="col-lg-12">
                                <div class="dropdown" style="float:left;">
                                    <button class="btn btn-default dropdown-toggle btn-menu" type="button" id="textMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="width:35px;">
                                        <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="textMenu">
                                        <li><a href="javascript:void(0);" id="addTextCategory">New Category</a></li>
                                        <li><a href="javascript:void(0);" id="edittext">Edit Category</a></li>
                                        <li><a href="javascript:void(0);" id="upload_link" style="margin-bottom: -18px;">Add Pattern Images</a>​</li>
                                        <li><a href="javascript:void(0);" id="saveText">Save from Selection</a></li>
                                        <li><a href="javascript:void(0);" id="deletetextcat">Delete Category</a></li>
                                        <li><a href="javascript:void(0);" id="deleteText">Delete Text</a></li>
                                    </ul>
                                </div>
                                <select class="form-control" name="textcat-select" id="textcat-select">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <input id="pattern_img" type="file"/>
                            <div id="pattern_imagelist" class="col-lg-12" style="margin-top: -20px">
                            </div>
                            <div id="addtextoptions" class="col-lg-12" style="text-align:center; margin-left: 30px;">
                                <div id="addheading" style="font-size:36px; font-weight:900;"><a href="javascript:void(0);" onClick="javascript:addheadingText();">Add heading</a>
                                </div>
                                <div id="addsubheading" style="font-size:24px; font-weight:bold;"><a href="javascript:void(0);" onClick="javascript:addsubheadingText();">Add subheading</a>
                                </div>
                                <div id="addsometext" style="font-size:18px; font-weight:bold; margin:5px 0 10px 0;"><a href="javascript:void(0);" onClick="javascript:addText();">Add some regular text</a>
                                </div>
                            </div>
                            <div class="" id="text_container" style="text-align:center;">
                            </div>
                        </div>
                        <div class="tab-pane" id="c">
                            <div class="col-lg-12">
                                <div class="dropdown" style="float:left;">
                                    <button class="btn btn-default dropdown-toggle btn-menu" type="button" id="elementMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="width:35px;">
                                        <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="elementMenu">
                                        <li><a href="javascript:void(0);" id="addCategory">New Category</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="editelement">Edit Category</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="addElement">New Element</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="saveElement">Save from Selection</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="deleteCategory">Delete Category</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="deleteEle">Delete Element</a>
                                        </li>
                                    </ul>
                                </div>
                                <select class="form-control" name="cat-select" id="cat-select">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="col-lg-12 col-xs-12" id="catimage_container" style="text-align:center;">
                            </div>
                        </div>
                        <div class="tab-pane" id="d">
                            <div class="col-lg-12">
                                <div class="dropdown" style="float:left;">
                                    <button class="btn btn-default dropdown-toggle btn-menu" type="button" id="backgroundMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="backgroundMenu" style="z-index: 10000000;">
                                        <li><a href="javascript:void(0);" id="addBGCategory">New Category</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="editbackground">Edit Category</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="addBackground">New Background</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="deleteBGCategory">Delete Category</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="deleteBackground">Delete Background</a>
                                        </li>
                                        <li><a href="javascript:void(0);" id="geofilterBackground">Add or Update GeoFilter</a>
                                        </li>
                                    </ul>
                                </div>
                                <select class="form-control" name="bgcat-select" id="bgcat-select">
                                    <option value="">Select Category</option>
                                </select>
                                <button class="btn btn-alt4" type="button" style="width:50px;"  id="bgImageRemove"> <i class="fa fa-trash-o fa-lg" style="cursor:pointer;"></i></button>
                                <button class="btn btn-alt4" type="button" style="width:50px;" id="bgselect"> <i class="fa fa-eyedropper fa-lg" style="cursor:pointer;"></i></button>
                                <button class="btn btn-alt4" type="button" style="width:50px;" id="scale"> <i class="fa fa-expand fa-lg" style="cursor:pointer;"></i></button>
                            </div>
                            <div class="col-lg-12 col-xs-12" style="text-align:center;" id="bgclorselect">
                                <button class="btn btn-default" type="button" id="bgcolorselect">Select Color</button>
                            </div>
                            <div class="col-lg-12 col-xs-12" style="text-align:center;margin-top: 20px;" id="expandscale">
                                <p>
                                    <label style="color:#e6e6e5;font-weight: 100;">Background Scale</label>
                                    <input type="range" min="25" max="100" value="100" id="img-width">
                                </p>
                            </div>
                           <div class="col-lg-12 col-xs-12" id="background_container" style="text-align:center;margin-top: 20px;"></div>
                        </div>
                        <div class="tab-pane" id="e">
                            <div>
                                <div id="shapeoption">
                                    <div class="row">
                                        <div class="col-md-12" style="float:center;">
                                            <select id='shapeselectdropdown' name="" onChange='javascript:addShape(this.value);' class="form-control">
                                                <option value="">Select Shape</option>
                                                <option value="rectangle">Rectangle</option>
                                                <option value="triangle">Triangle</option>
                                                <option value="square">Square</option>
                                                <option value="circle">Circle</option>
                                                <option value="line">Line</option>
                                            </select>
                                        </div>
                                    </div></br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6" style="color:#9a9b9c;">Select Outline Color</div>
                                            <button id="strokeline" class="col-md-1 btn btn-small" style="width: 100px;color:#9a9b9c;"><i class="fa fa-paint-brush"></i></button>
                                        </div>
                                    </div></br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6" style="color:#9a9b9c;">Select Outline Width</div>
                                            <select name="" class="col-md-1 form-control" style="width:100px;margin-left: 5px;" id="storkewidth">
                                                <option value="0" selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                    </div></br>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="f">
                            <div class="col-lg-12">
                                <form role="form" name="donwloadlimitmodal" id="donwloadlimitmodal">
                                  <?php
                                        $query = "SELECT * FROM download_imit";
                                        $runQuery = mysql_query($query);
                                        if(mysql_num_rows($runQuery) > 0)
                                        {
                                            while($row = mysql_fetch_array($runQuery))
                                            { 
                                    ?>
                                        <div class="modal-body" style="margin-top:-30px; ">
                                            <div class="row">
                                                <div class="page-header">
                                                    <h3 style="text-align:center;color:#111111;font-Family:Open Sans;font-size:20px;">Download Limits</h3>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="col-md-6" style="color:#ffffff;">PDF Limits</div>
                                                    <input type="text" name="pdflimit" id="pdflimit" class="col-md-3" value="<?php echo $row['pdf_limit']; ?>">
                                                </div><br><br>
                                                <div class="col-md-12">
                                                    <div class="col-md-6" style="color:#ffffff;">JPEG Limits</div>
                                                    <input type="text" name="jpeglimit" id="jpeglimit" class="col-md-3" value="<?php echo $row['jpeg_limit']; ?>">
                                                </div><br><br>
                                                <div class="col-md-12">
                                                    <div class="col-md-6" style="color:#ffffff;">PNG Limits</div>
                                                    <input type="text" name="pnglimit" id="pnglimit" class="col-md-3" value="<?php echo $row['png_limit']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                           }
                                        } 
                                    ?> 
                                    <div class="modal-footer" style="padding:10px;">
                                        <button type="submit" class="btn btn-default"  style="float:right">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <ul class="list-unstyled hidden-xs" id="sidebar-footer">
                        <li>
                            <i class="fa fa-plus-circle fa-lg" id="btnZoomIn" style="cursor:pointer;"></i>
                            </br><span id="zoomperc">100%</span>
                            </br><i class="fa fa-minus-circle fa-lg" id="btnZoomOut" style="cursor:pointer;"></i>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="" style="position: relative;left: 0;margin-left: 90px;min-height: 100%;height: 100vh;padding-top: 60px;" id='rightsection' align="center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tools-top" style="background-color:#cebc7c;  visibility: hidden; height: 80px; width: 100%; position: fixed; z-index: 999;  opacity: 0.8;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tools-top" style="font-size:6px; z-index: 1000; visibility: hidden; margin-top: 25px; margin-left: 45px; position: fixed; left: 51%; transform: translate(-50%, 0px);">
                    <div class="toolbar-top">
                        <span class="textelebtns" style="display: inline;">
                            <div class="btn-group">
                                <a title="Select Font" id="font-selected" class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" style="width:150px; overflow: hidden;">
                                    <span><span style="font-family: 'Averia Sans Libre'; font-size: 14px;">Averia Sans Libre</span>&nbsp;&nbsp;<span class="caret"></span></span>
                                </a>
                                <ul class="dropdown-menu fonts-dropdown" id="fonts-dropdown">
                                    <?php
                                        $query = "SELECT * FROM font_file";
                                        $runQuery = mysql_query($query);
                                        if(mysql_num_rows($runQuery) > 0)
                                        {
                                            while($row = mysql_fetch_array($runQuery))
                                            { 
                                                        $new_file = str_replace("_"," ",$row['ff_name']);

                                                echo "<li><a href='javascript:void(0);''><font face='".$new_file."' size='4'>".$new_file."</font></a></li>";            
                                           }
                                        } 
                                    ?>
                                </ul>
                            </div>
                            <div class="input-group" style="display:inline-block;">
                                <input type="text" class="fontinput form-control" id="fontsize" name="fontsize" min="0" max="100" value="6" style="width:50px; display:inline-block;">
                                <div class="input-group-btn" style="display:inline-block;">
                                    <a id="fzbutton" title="Font Size" class="tools-top btn btn-default fzbutton-container dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" style="padding:2px 5px;margin-left:-13px;"> <i id="fontsizeInc" class="fa fa fa-caret-up fzbutton" style="display:block;"></i> <i id="fontsizeDec" class="fa fa-caret-down fzbutton" style="display:block;"></i></a>
                                    <ul class="dropdown-menu font-size-dropdown" id="font-size-dropdown">
                                        <li><a href="javascript:void(0);">6</a></li>
                                        <li><a href="javascript:void(0);">8</a></li>
                                        <li><a href="javascript:void(0);">10</a></li>
                                        <li><a href="javascript:void(0);">12</a></li>
                                        <li><a href="javascript:void(0);">14</a></li>
                                        <li><a href="javascript:void(0);">16</a></li>
                                        <li><a href="javascript:void(0);">18</a></li>
                                        <li><a href="javascript:void(0);">20</a></li>
                                        <li><a href="javascript:void(0);">22</a></li>
                                        <li><a href="javascript:void(0);">24</a></li>
                                        <li><a href="javascript:void(0);">26</a></li>
                                        <li><a href="javascript:void(0);">28</a></li>
                                        <li><a href="javascript:void(0);">30</a></li>
                                        <li><a href="javascript:void(0);">36</a></li>
                                        <li><a href="javascript:void(0);">48</a></li>
                                        <li><a href="javascript:void(0);">60</a></li>
                                        <li><a href="javascript:void(0);">72</a></li>
                                        <li><a href="javascript:void(0);">96</a></li>
                                        <li><a href="javascript:void(0);">120</a></li>
                                        <li><a href="javascript:void(0);">144</a></li>
                                    </ul>
                                </div>
                            </div>
                        </span>
                        <span>
                        <a href="javascript:void(0);" id="colorSelector" title="Color Picker" class="tools-top btn btn-default" style="padding: 16px 19px; margin-left: 3px;"></a>
                        <span id='dynamiccolorpickers'></span>
                        <a href="javascript:void(0);" id="fontbold" title="Bold" class="tools-top btn btn-default"><i class="fa fa-bold" aria-hidden="true"></i></a>
                        <a href="javascript:void(0);" id="fontitalic" title="Italic" class="tools-top btn btn-default"><i class="fa fa-italic" aria-hidden="true"></i></a>
                        <div id="showmoreoptionstxtali" class="btn-group" style="display:inline-block;">
                            <a href="javascript:void(0);" id="showmore" data-toggle="dropdown" title="Show More Tools" class="tools-top btn btn-default dropdown-toggle alignment"></a>
                            <ul class="dropdown-menu dropdown-menu-right" style="min-width: 1px;">
                                <li style="display: inline-flex;margin-top: 10px;">
                                    <button href="javascript:void(0);" id="objectalignleft" class="tools-top btn btn-default" style="border: 0;" title="Align Left"><a href="javascript:void(0);"  class="btn btn-default" style="border: 0;padding: 0;"><i class="fa fa-align-left"></i></a></button>
                                    <button href="javascript:void(0);" id="objectaligncenter" class="tools-top btn btn-default" style="border: 0;" title="Align center"><a href="javascript:void(0);" class="btn btn-default" style="border: 0;padding: 0;"><i class="fa fa-align-center"></i></a></button>
                                    <button href="javascript:void(0);" id="objectalignright" class="tools-top btn btn-default" style="border: 0;" title="Align Right"><a href="javascript:void(0);" class="btn btn-default" style="border: 0;padding: 0;"><i class="fa fa-align-right"></i></a></button>
                                    <button href="javascript:void(0);" id="objectalignjustify" class="tools-top btn btn-default" style="border: 0;" title="Align Justify"><a href="javascript:void(0);" class="btn btn-default" style="border: 0;padding: 0;"><i class="fa fa-align-justify"></i></a></button>                        
                                </li>
                            </ul>
                        </div>  
                        <a href="javascript:void(0);" id="textuppercase" title="uppercase" class="tools-top btn btn-default"><img src="img/Uppercase-Text-icon.png" width="14"></a>
                        <a href="javascript:void(0);" id="textlowercase" title="lowerletter" class="tools-top btn btn-default"><img src="img/lowerletter.png" width="14"></a>
                        <a href="javascript:void(0);" id="textcapitalize" title="capitalize" class="tools-top btn btn-default"><img src="img/capitalize.png" width="14"></a>                      
                        <a href="javascript:void(0);" id="clone" title="Clone Object" class="tools-top btn btn-default"><i class="fa fa-clone"></i></a>
                        <a href="javascript:void(0);" id="sendbackward" title="Send Backward" class="tools-top btn btn-default"><img src="img/send-backward.svg" height="16" width="16" /></a>
                        <a href="javascript:void(0);" id="bringforward" title="Bring Forward" class="tools-top btn btn-default"><img src="img/bring-forward.svg" height="16" width="16" /></a>
                        <div id="showmoreoptions" class="btn-group" style="display:inline-block;">
                            <button href="javascript:void(0);" id="showmore" data-toggle="dropdown" title="Show More Tools" class="tools-top btn btn-default dropdown-toggle"><i class="fa fa-list-ul" aria-hidden="true"></i></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);" id="lineheight" title="Line Height" class="tools-top more textelebtns noclose" ><i class="fa fa-text-height" aria-hidden="true"></i>&nbsp; Line Height</a></li>
                                <li><a href="javascript:void(0);" id="charspacing" title="Letter Spacing" class="tools-top more textelebtns noclose" ><i class="fa fa-text-width" aria-hidden="true"></i>&nbsp; Letter Spacing</a></li>
                                <input id="changelineheight" data-slider-id='lineheightSlider' type="text" data-slider-min="0.5" data-slider-max="5" data-slider-step="0.1" data-slider-value="1.3"/>
                                <input id="changecharspacing" data-slider-id='charspacingSlider' type="text" data-slider-min="-200" data-slider-max="800" data-slider-step="10" data-slider-value="200"/>
                            </ul>
                        </div>
                        <a href="javascript:void(0);" id="deleteitem" title="Delete Selected Item" class="tools-top btn btn-danger"><i class="fa fa-trash-o"></i></a>
                        <div id="showmoreoptions" class="btn-group" style="display:inline-block;">
                            <button href="javascript:void(0);" id="showmore" data-toggle="dropdown" title="Show More Tools" class="tools-top btn btn-default dropdown-toggle"><span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0);" id="fontunderline" title="Underline" class="tools-top more textelebtns" style="text-decoration: underline;">Underline</a></li>
                                <li><a href="javascript:void(0);" id="objectfliphorizontal" title="Flip Horizontal" class="tools-top more"><img src="img/fliphorizontally.png" width="14">&nbsp; Flip Horizontally</a></li>
                                <li><a href="javascript:void(0);" id="objectflipvertical" title="Flip Vertical" class="tools-top more"><img src="img/flipvertically.png" width="14">&nbsp; Flip Vertically</a></li>
                                <li><a href="javascript:void(0);" id="objectlock" title="Lock Object" class="tools-top more"><i class="fa fa-lock"></i>&nbsp;&nbsp; Lock Object</a></li>
                                <li><a href="javascript:void(0);" id="objectopacity" title="Opacity" class="tools-top more noclose"><img src="img/opacity.svg" width="13">&nbsp; Opacity</a></li>
                                <input id="changeopacity" data-slider-id='opacitySlider' type="text" data-slider-min="0.1" data-slider-max="1" data-slider-step=".1" data-slider-value="1" />
                            </ul>
                        </div>
                        <a href="javascript:void(0);" id="cropimage" title="Crop Selected Image" class="tools-top btn btn-default">Crop Image</a>
                        <a href="javascript:void(0);" id="replace_image" title="Replace image" class="tools-top btn btn-default">Replace image</a>
                        <span id="imagecropOptions">
                        <a href="javascript:zoomBy(0,0,10);" title="Zoom In" class="tools-top btn btn-default"><i class="fa fa-search-plus"></i></a>
                        <a href="javascript:zoomBy(0,0,-10);" title="Zoom Out" class="tools-top btn btn-default"><i class="fa fa-search-minus"></i></a>
                        <a href="javascript:zoomBy(-5,0,0);" title="Shift Left" class="tools-top btn btn-default"><i class="fa fa-arrow-left"></i></a>
                        <a href="javascript:zoomBy(5,0,0);" title="Shift Right" class="tools-top btn btn-default"><i class="fa fa-arrow-right"></i></a>
                        <a href="javascript:zoomBy(0,-5,0);" title="Shift Up" class="tools-top btn btn-default"><i class="fa fa-arrow-up"></i></a>
                        <a href="javascript:zoomBy(0,5,0);" title="Shift Down" class="tools-top btn btn-default"><i class="fa fa-arrow-down"></i></a>
                        </span>
                        </span> 
                    </div>
                </div>
                </div>
                
            <div class="tab-content" id='canvasbox-tab' style=' margin-top: 60px;text-align: -webkit-center; display: inline-block;' align="center">
                <span id='infotext' style='font-size: 10px; opacity: 0.8; position: relative; left: 0px; top: 0px; z-index: 1000;'></span>
                <div id='canvaspages' tabindex="0" style='outline:none;'>
                </div>
				<!--
					<div id='divcanvas0' class="divcanvas" onClick='javascript:selectCanvas(this.id);'>
					</div>
				-->
                <div style="display:none; float:right; margin-top: -240px; margin-right: 112px; color:#ffffff;">
                    <img id="duplicatecanvas" class="fa fa-plus duplicatecanvas" style="cursor:pointer; color:#717171;  width: 20px;" src="img/duplicate.png">
                    </br>
                    </br>
                    <img id="addnewpagebutton" class="fa fa-plus addnewpagebutton" style="cursor:pointer; color:#717171;  width: 20px;" src="img/addpagenew.png">
                    </br>
                    </br>
                    <img id="deletecanvas" class="fa fa-plus deletecanvas" style="cursor:pointer; color:#717171;  width: 20px;" src="img/delet.png">
                    </br>
                    </br>
                    </br>
                    </br>
                    </br>
                    <i id='moveup' class="fa fa-sort-asc fa-2 moveup" style='cursor:pointer; color:#717171;font-size: 30px;'></i>
                    </br>
                    <span style="margin-left: 5px;margin-top: 4px;" id='pagenumber'>1</span>
                    </br>
                    </br>
                    <i id='movedown' class="fa fa-sort-desc movedown" style='cursor:pointer; color:#717171;font-size: 30px;'></i>
                    </br>
                    </br>
                    </br>
                    </br>
                    </br>
                    </br>
                    <i class="fa fa-chevron-circle-left backward" id="backward" style="font-size:36px;display: none;"></i>
                    <i class="fa fa-chevron-circle-right forward" id="forward" style="font-size:36px;display: none;"></i> 
               </div>
                <div style="display:none;">
                    <canvas id="outputcanvas" width="750" height="600" class="canvas"></canvas>
                </div>
                <div style="display:none;">
                    <canvas id="tempcanvas" width="100" height="100" class="canvas"></canvas>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div id="edit_tempname" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Template Name</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="edit_tid" name="edit_tid" value="edit_tid" />

                        <div class="form-group col-lg-12">
                            <div class="form-group col-md-3">
                                <label for="exampleInputName2">Category:</label>
                            </div>
                            <div class="form-group col-md-9">
                                <select class="form-control" id="edit_tmpcat" name="edit_tmpcat">
                                    <?php require("library/config.php");
										$query="SELECT * FROM template_categories";
										$runQuery=mysql_query($query);
										if (mysql_num_rows($runQuery)){
											echo "<option value=''>Select Category</option>";
											while ($row=mysql_fetch_assoc($runQuery)){
												echo "<option value='$row[tempcat_id]'>$row[tempcat_name]</option>";
											}
										}
									 ?>
                                </select>
                            </div>
                            <br>
                        </div>

                        <div class="form-group col-lg-12">
                            <div class="form-group col-md-3">
                                <label for="exampleInputName2">Template Name:</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" name="edit_tmpname" class="form-control" id="edit_tmpname" placeholder="" required>
                            </div>
                            <br>
                        </div>
						
						<div class="form-group col-lg-12">
                            <div class="form-group col-md-4">
                                <label for="exampleInputName2">Shopify Product Id:</label>
                            </div>
                            <div class="form-group col-md-8">
                                <input type="text" name="edit_proid" class="form-control" id="edit_proid" placeholder="" required>
                            </div>
                            <br>
                        </div>
						<div class="form-group col-lg-12">
                            <div class="form-group col-md-4">
                                <label for="exampleInputName2">Etsy Listing ID:</label>
                            </div>
                            <div class="form-group col-md-8">
                                <input type="text" name="edit_listid" class="form-control" id="edit_listid" placeholder="" required>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onClick="updatetemp()">Update</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="edit_catname" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Category Name</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="edit_cid" name="edit_cid" value="edit_cid" />
                        <div class="form-group col-lg-12">
                            <div class="form-group col-md-3">
                                <label for="exampleInputName2">Category Name:</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" name="edit_cname" class="form-control" id="edit_cname" placeholder="" required>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onClick="updatecat()">Update</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="edit_textcatname" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Category Name</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="edit_textcid" name="edit_textcid" value="edit_textcid" />
                        <div class="form-group col-lg-12">
                            <div class="form-group col-md-3">
                                <label for="exampleInputName2">Category Name:</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" name="edit_textcname" class="form-control" id="edit_textcname" placeholder="" required>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onClick="updatetextcat()">Update</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="edit_elecatname" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Category Name</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="edit_elecid" name="edit_elecid" value="edit_elecid" />
                        <div class="form-group col-lg-12">
                            <div class="form-group col-md-3">
                                <label for="exampleInputName2">Category Name:</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" name="edit_elecname" class="form-control" id="edit_elecname" placeholder="" required>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onClick="updateelecat()">Update</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="edit_backname" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Category Name</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="edit_backcid" name="edit_backcid" value="edit_backcid" />
                        <div class="form-group col-lg-12">
                            <div class="form-group col-md-3">
                                <label for="exampleInputName2">Category Name:</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" name="edit_backcname" class="form-control" id="edit_backcname" placeholder="" required>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" onClick="updatebackcat()">Update</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="successModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-300">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Success</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span id="successMessage"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <div id="alertModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-300">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px;background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span id="responceMessage"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <div id="svgalertModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-300">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px;background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span> Only svg file allowed! </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <div id="Addcategoryodal" class="modal fade">
        <div class="modal-dialog modal-content-400">
            <div class="modal-content">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px;background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Add Category</h4>
                </div>
                <form role="form" name="addcategoryform" id="addcategoryform">
                    <div class="modal-body" style="margin-top:-30px; ">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="category">Category</label>
                                <input type="text" name="category" id="category" class="form-control" placeholder="Enter Category">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="reset" class="btn btn-default btn-small" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-default btn-small">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="Del_templatecatmodal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-400">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Delete Category</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span>Are you sure you want to delete the category?</span>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:proceed_tempcatdelete();">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <div id="Del_catmodal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-400">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px;background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Delete Category</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span>Are you sure you want to delete the category?</span>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:proceed_catdelete();">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <div id="Del_bgcatmodal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-400">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px;background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Delete Category</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span>Are you sure you want to delete the category?</span>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:proceed_Bgcatdelete();">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <div id="Del_textcatmodal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-400">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Delete Category</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span>Are you sure you want to delete the category?</span>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:proceed_textcatdelete();">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <div id="AddTemplatecategoryModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-400">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px;background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Add Category</h4>
                </div>
                <form role="form" name="addtemplatecategoryform" id="addtemplatecategoryform">
                    <div class="modal-body" style="margin-top:-30px; ">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="category">Category</label>
                                <input type="text" name="templatecategory" id="templatecategory" class="form-control" placeholder="Enter Category">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="reset" class="btn btn-default btn-small" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-default btn-small">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="AddTextcategoryModal" class="modal fade">
        <div class="modal-dialog modal-content-400">
            <div class="modal-content">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Add Text Category</h4>
                </div>
                <form role="form" name="addtextcategoryform" id="addtextcategoryform">
                    <div class="modal-body" style="margin-top:-30px; ">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="category">Category</label>
                                <input type="text" name="textcategory" id="textcategory" class="form-control" placeholder="Enter Text Category">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="reset" class="btn btn-default btn-small" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-default btn-small">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="savetemplate_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-500">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Save Flyer</h4>
                </div>
                <form role="form" name="savetemplateform" id="savetemplateform">
                    <div class="modal-body" style="margin-top:-30px; ">
                        <div class="body">
                            <span><label for="template">Category :</label>
                           <select class="form-control" name="template_category" id="template_category" required>
                              <option value="">Select Category</option>
                           </select>
                              </span>
                            </br>
                            <span><label for="template">Flyer Name :</label>
                           <input type="text" name="templatename" id="templatename" class="form-control" placeholder="Enter Name"></span>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="downloadtemplate_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-500">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title" style="color:#ffffff;">Download Flyer</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span><label for="template">Flyer Name :</label>
                           <input type="text" name="downtemplatename" id="downtemplatename" class="form-control" placeholder="Enter Name"></span>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:downloadTemplateFile();">Download</button>
                </div>
            </div>
        </div>
    </div>
    <div id="savetext_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-500">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Save Text</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span><label for="template">Category :</label>
                           <select class="form-control" name="text_category" id="text_category" >
                              <option value="">Select Category</option>
                           </select>
                              </span>
                        </br>
                        <span><label for="template">Text Name :</label>
                           <input type="text" name="textname" id="textname" class="form-control" placeholder="Enter Name"></span>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:savetextfromselection();">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div id="saveelement_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-500">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Save Element</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span><label for="template">Category :</label>
                           <select class="form-control" name="elmt_category" id="elmt_category" >
                              <option value="">Select Category</option>
                           </select>
                              </span>
                        </br>
                        <span><label for="template">Element Name :</label>
                           <input type="text" name="elmtname" id="elmtname" class="form-control" placeholder="Enter Name"></span>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onClick="javascript:saveelementsfromselection();">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div id="AddBGcategoryodal" class="modal fade">
        <div class="modal-dialog modal-content-400">
            <div class="modal-content">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Add Category</h4>
                </div>
                <form role="form" name="addbgcategoryform" id="addbgcategoryform">
                    <div class="modal-body" style="margin-top:-30px; ">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="category">Category</label>
                                <input type="text" name="bgcategory" id="bgcategory" class="form-control" placeholder="Enter Category">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="reset" class="btn btn-default btn-small" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-default btn-small">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="canvaswh_modal" class="modal fade" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content modal-content-400">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png"></button>
                    <h4 class="modal-title">Canvas Width / Height</h4>
                </div>
                <form action="javascript:void(0);" name="canvaswhForm" id="canvaswhForm" method="post">
                    <div class="modal-body" style="margin-top:-30px; ">
                        <div class="body">
                            <span><label for="template">Canvas width (in inches):</label>
                           <input type="text" name="loadCanvasWid" id="loadCanvasWid" class="form-control" placeholder="Enter Width" value='5'>
                              </span>
                            </br>
                            <span><label for="template">Canvas height (in inches):</label>
                           <input type="text" name="loadCanvasHei" id="loadCanvasHei" class="form-control" placeholder="Enter Height" value='7'></span>
                            </br>
                            <span><label for="template">Number of Canvas rows</label>
                           <input type="text" name="numOfcanvasrows" id="numOfcanvasrows" class="form-control" value="1"></span>
                            </br>
                            <span><label for="template">Number of Canvas columns</label>
                           <input type="text" name="numOfcanvascols" id="numOfcanvascols" class="form-control" value="1"></span>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="se-pre-con" style="opacity: 0.8;"></div>
    <!--<div id="spinnerModal" class="modal fade" data-backdrop="static" data-keyboard="false"><i class="fa fa-refresh fa-spin" style="position: absolute; top: 50%; left: 50%; margin-top: -75px; margin-left: -75px; font-size: 150px;"></i>
    </div>-->
    <div id="imagealertModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-400">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">IMAGE FILE FORMAT / SIZE MISMATCH.</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <label>Please upload your image format in JPG/PNG/GIF. Each file size is limited to 3000 KB.</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <div id="AddelementModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-500">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Add Element</h4>
                </div>
                <form role="form" name="addelementform" id="addelementform">
                    <div class="modal-body" style="margin-top:-30px; ">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="element_category">Category</label>
                                <select class="form-control" name="element_category" id="element_category">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="element_name">Element Name</label>
                                <input type="text" name="element_name" id="element_name" class="form-control" placeholder="Enter Element">
                            </div>
                            <div class="form-group col-lg-12">
                                <label name="element">Element</label>
                            </div>
                            <div class="form-group element-upload col-lg-3">
                                <label for="element_img" class="btn btn-default btn-block"><i class="fa fa-cloud-upload"></i> Upload</label>
                                <input id="element_img" type="file" onchange="readIMG(this);" name="element_img" />
                            </div>
                            <img id="previewImage" src="javascript:void(0);" alt="Your image" style="display:none;" />
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="reset" class="btn btn-default btn-small" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-default btn-small">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crop_imagepopup" aria-labelledby="modalLabel" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalLabel">Crop the image</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <!--<img id="imagetocrop" src="img/429.png" alt="Picture">-->
                        <img id="imagetocrop" src="" alt="Picture">
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move" onClick='javascript:setDragMode("move");'>
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;move&quot;)">
					  <span class="fa fa-arrows"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop" onClick='javascript:setDragMode("crop");'>
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
					  <span class="fa fa-crop"></span>
                            </span>
                        </button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In" onClick='javascript:zoom(0.1);'>
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
					  <span class="fa fa-search-plus"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out" onClick="javascript:zoom(-0.1);">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
					  <span class="fa fa-search-minus"></span>
                            </span>
                        </button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left" onClick="javascript:move(-10,0);">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
					  <span class="fa fa-arrow-left"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right" onClick="javascript:move(10,0);">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
					  <span class="fa fa-arrow-right"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up" onClick='javascript:move(0,-10);'>
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
					  <span class="fa fa-arrow-up"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down" onClick='javascript:move(0,10);'>
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
					  <span class="fa fa-arrow-down"></span>
                            </span>
                        </button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left" onClick="javascript:rotate(-45);">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
					  <span class="fa fa-rotate-left"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right" onClick="javascript:rotate(45);">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
					  <span class="fa fa-rotate-right"></span>
                            </span>
                        </button>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal" onClick="javascript:scaleX(-1);">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
					  <span class="fa fa-arrows-h"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical" onClick="javascript:scaleY(-1);">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
					  <span class="fa fa-arrows-v"></span>
                            </span>
                        </button>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="disable" title="Disable" onClick="javascript:disable();">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.disable()">
					  <span class="fa fa-lock"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" data-method="enable" title="Enable" onClick="javascript:enable();">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.enable()">
					  <span class="fa fa-unlock"></span>
                            </span>
                        </button>
                    </div>

                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-method="reset" title="Reset" onClick="javascript:reset();">
                            <span class="docs-tooltip" data-toggle="tooltip" title="cropper.reset()">
					  <span class="fa fa-refresh"></span>
                            </span>
                        </button>

                    </div>
                    <button type="button" class="btn btn-primary" title="Save" data-method="getCroppedCanvas" id="getCroppedCanvas" name='getCroppedCanvas'>Save</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="AddbackgroundModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-500">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title">Add Background</h4>
                </div>
                <form role="form" name="addbackgroundform" id="addbackgroundform">
                    <div class="modal-body" style="margin-top:-30px; ">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="element_category">Category</label>
                                <select class="form-control" name="bg_category" id="bg_category">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="element_name">Background Name</label>
                                <input type="text" name="bg_name" id="bg_name" class="form-control" placeholder="Enter Background Name">
                            </div>
                            <div class="form-group col-lg-12">
                                <label name="background">Background</label>
                            </div>
                            <div class="form-group bg-upload col-lg-3">
                                <label for="bg_img" class="btn btn-default btn-block"><i class="fa fa-cloud-upload"></i> Upload</label>
                                <input id="bg_img" type="file" onchange="readBGIMG(this);" name="bg_img" />
                            </div>
                            <img id="previewBGImage" src="javascript:void(0);" alt="Your image" style="display:none;" />
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="reset" class="btn btn-default btn-small" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-default btn-small">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="AdduploadimageModal" class="modal fade edit-object" tabindex="-1" role="dialog" aria-labelledby="imageModalTitle" aria-hidden="true" data-editor-image-modal>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="imageModalTitle">Add Image</h4>
			</div>
			<div class="modal-body">
				<div class="images-insert">
					<div class="row">
						<div class="col-lg-5 imageBG-upload">
							<form id="upload" action="uploadimage.php" method="POST" enctype="multipart/form-data">
                                <!--<input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="3072000" />-->
                                <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="18874368" />
								<label for="fileselect" class="images-button btn btn-block btn-lg btn-primary" style="background-color:#cebc7c;border-color:#cebc7c;"><i class="fa fa-cloud-upload"></i> Upload image</label>
								<input id="fileselect" type="file" name="fileselect[]" />
							</form>
							<div id="progress"></div>
						</div>
					</div>
					<div id="image_container" style="position: relative;height:450px;">
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
    <div id="AdduploadfileModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-500">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; background-color:#cebc7c;border-color:#cebc7c;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="img/close.png">
                    </button>
                    <h4 class="modal-title" style="color:#ffffff;">Add Font File</h4>
                </div>
				 <form role="form" name="addfontformodal" id="addfontformodal">
                    <div class="modal-body" style="margin-top:-30px; ">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label name="element">Font File</label><br>
								<div class="form-group imageBG-upload" style="margin-left: 50px;">
									<input id="element_file" type="file" name="element_file" />
								</div>
                            </div>
                            <div class="form-group col-lg-12">
                                <label name="element">Added Custom Font List</label><br>
                                  <div id="deletefont" style="max-height: 210px; overflow: auto;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="reset" class="btn btn-default btn-small" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-default btn-small">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="js/jquery.dd.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.2/isotope.pkgd.min.js"></script>
<script src="https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>
<script type="text/javascript" src="js/bootstrap-slider.js"></script>
<!--<script type="text/javascript" src="js/fabric1.6.js"></script>-->
<script type="text/javascript" src="js/fabric1.7.2.js?v=0.9"></script>
<script type="text/javascript" src="js/aligning_guidelines.js"></script>
<script type="text/javascript" src="js/centering_guidelines.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/validation-methods.js"></script>
<script src="js/jquery-validate.bootstrap-tooltip.js"></script>
<script src="js/filedrag.js" type="text/javascript"></script>
<script type="text/javascript" src="js/spectrum.js"></script>
<script type="text/javascript" src="js/fileSaver.min.js"></script>
<script type="text/javascript" src="js/cropper.min.js"></script>
<!--<script src="js/jspdf.debug.js"></script>-->
<script type="text/javascript">
    var tempcanvas = new fabric.Canvas(document.getElementById('tempcanvas'));
    var canvas = new fabric.Canvas(document.getElementById('canvas0'));
    canvas.rotationCursor = 'url("img/rotatecursor2.png") 10 10, crosshair';
    canvas.backgroundColor = '#ffffff';
    var selectedFont = 'Arial';
    var fillColor = 'Black';
</script>
<script>document.write("<script type='text/javascript' src='js/functions.js?v=2.7" + Date.now() + "'><\/script>");</script>
<script>document.write("<script type='text/javascript' src='js/canvasevents.js?v=3.1" + Date.now() + "'><\/script>");</script>
<script>
        
	$(window).load(function() { 

        $("#expandscale").slideToggle("hide");
        $("#bgclorselect").slideToggle("hide");

		$("#loadingpage").fadeOut("slow");
		/* $("#canvaswh_modal").modal('show');*/
		if (window.location.href.indexOf('?newtemplate') != -1) {
			$("#canvaswh_modal").modal('show');
		}
		$('.deletecanvas').css('display', 'none');
	});

    $(function(){
        $("#upload_link").on('click', function(e){
            e.preventDefault();
            $("#pattern_img:hidden").trigger('click');
        });
    });

	var Istempselected = false;
	var Iscatselected = false;
	var IsBgselected = false;
	var IsTextselected = false;
    var selectedcategory = "";

	$(document).ready(function() {
       setTimeout(function() {
            displaypattern();
        }, 300);
		getTemplates('');
        setTimeout(function() {
            delfontfile();
        }, 250);
        setTimeout(function() {
            gettempcategory();
        }, 500);
		setTimeout(function() {
			getTemplatesName();
		}, 750);
		setTimeout(function() {
			getcategory();
		}, 1000);
		setTimeout(function() {
			getcatimages('');
		}, 1250);
		setTimeout(function() {
			getBgcategory();
		}, 1500);
		setTimeout(function() {
			getbgimages('');
		}, 1750);
		setTimeout(function() {
			getTextcategory();
		}, 2500);
		setTimeout(function() {
			getTexts('');
		}, 2750);
        setTimeout(function() {
            getuploadimages();
        }, 3000);
		$('#cat-select').change(function() {
			var selectedID = $(this).val();
			Iscatselected = true;
			$('#catimage_container').empty();
			getcatimages(selectedID);
		});
		$('#tempcat-select').on('change', function() {
			Istempselected = true;
			$('#template_container').empty();
			getTemplates($(this).val());

            var optionSelected = $(this).find("option:selected");
            selectedcategory   = optionSelected.text();
		});

		$('#textcat-select').on('change', function() {
			Istextselected = true;
			$('#text_container').empty();
			getTexts($(this).val());
		});
		$('#bgcat-select').on('change', function() {
			IsBgselected = true;
			$('#background_container').empty();
			getbgimages($(this).val());
		});
	});
	$('.noclose').on('click', function(e) {
		e.stopPropagation();
	});
	$(document).ready(function() {
         $('#scale').on('click', function (event) {
              $('#expandscale').slideToggle("slow");
         });
         $('#bgselect').on('click', function (event) {
              $('#bgclorselect').slideToggle("slow");
         }); 
		$(".dropdown-submenu").click(function(event) {
			event.stopPropagation();
			$(this).find(".dropdown-submenu").removeClass('open');
			$(this).parents(".dropdown-submenu").addClass('open');
			$(this).toggleClass('open');
		});
	});
	$(document).on("click", ".catImage", function() {
		var imagepath = $(this).data('imgsrc');
		addSVGToCanvas(imagepath);
		return false;
	});

	$(document).on("click", ".addImage", function() {
		var imgpath = $(this).data('imgsrc');
		addImage(imgpath);
		return false;
	});

    //Delete Patterm


    $('#pattern_imagelist').on('click', '#deletepattern', function() {
        var pattern_id  = $('#textpatternmenu').val();
        if (pattern_id != '') {
            $.ajax({
                type: 'POST',
                url: 'actions/del_pattern.php',
                data: 'res_id=' + pattern_id,
                success: function(respattern) { 
                    document.getElementById("successMessage").innerHTML = respattern;
                    $('#successModal').modal('show');
                    $('#pattern_imagelist').empty();
                    displaypattern();
                }
            });
        } else {
            $("#alertModal").modal('show');
            $('#responceMessage').html('Please select the Pattern, you wish to delete.');
        }

    });
        
    //display delete font files details
    function displaypattern() {
        $.ajax({
            type: 'GET',
            url: 'actions/getpatterns.php',
            cache: false,
            success: function(data) {
                if (data != '') {
                    linebreak = document.createElement("br");
                    $('#pattern_imagelist').append(linebreak);
                    $('#pattern_imagelist').append(data); 
                    $('#pattern_imagelist').append('<button class="col-md-3 btn btn-alt4" type="button" style="width:41px; margin-left: 58px; margin-top: 5px;" id="deletepattern"> <i class="fa fa-trash-o fa-lg" style="cursor:pointer;"></i></button>');
                    $("#textpatternmenu").msDropDown();
                    $("#textpatternmenu").on('change', function () {
                        var pmenu = $(this).find('option:selected').attr('id')
                        loadPattern(pmenu);
                    });
                }
            }
        });
    }

    //display delete font files details
    function delfontfile() {
        $.ajax({
            type: 'GET',
            url: 'actions/del_display_font.php',
            cache: false,
            success: function(data) {
                if (data != '') {
                    $('#deletefont').append(data);
                }
            }
        });
    }

    // delete font files
    function del_locat(id) {
        $.post("actions/delete_font.php", {
            "loc_id": id
        }, function(data) {
            if (data == "Deleted font Successfully."){
                $('#deletefont').empty();
                delfontfile();
            } 
        });
    }

	function addFileToCanvas(imagefile) {

		var actObj = canvas.getActiveObject();
		if (isReplaceImage && actObj && actObj.type == 'cropzoomimage') {
			var img = new Image();
			img.onload = function() {
				var w = actObj.width * actObj.scaleX;
				var h = actObj.height * actObj.scaleY;
				actObj.setElement(img);

				scalex = w / this.width;
				scaley = h / this.height;

				actObj.scaleX = scalex;
				actObj.scaleY = scalex;

				actObj.orgSrc = img.src;
				actObj.src = img.src;

                $(".se-pre-con").fadeOut('slow');
				$("#AdduploadimageModal").modal('hide');
				actObj.setCoords();
				canvas.renderAll();
			}
			img.src = "./uploads/" + imagefile;
			isReplaceImage = false;
		} else {
			fabric.util.loadImage("./uploads/" + imagefile, function(img) {
				var object = new fabric.Cropzoomimage(img, {
					left: canvas.getWidth() / 2,
					top: canvas.getHeight() / 2,
					scaleX: canvasScale / 2,
					scaleY: canvasScale / 2
				});
				object.src = "uploads/" + imagefile;
				canvas.add(object);
				canvas.setActiveObject(object);
				object.center();
				object.setCoords();
				setControlsVisibility(object);
                
                $(".se-pre-con").fadeOut('slow');
				$("#AdduploadimageModal").modal('hide');

				canvas.renderAll();
				saveState();
			}, {
				crossOrigin: ''
			});
		}
	}

	function addImage(imgpath) {

		var actObj = canvas.getActiveObject();
		if (isReplaceImage && actObj && actObj.type == 'cropzoomimage') {
			var img = new Image();
			img.onload = function() {

				w = actObj.width * actObj.scaleX;
				h = actObj.height * actObj.scaleY;

				actObj.setElement(img);
				actObj.src = imgpath;
				actObj.orgSrc = imgpath;

				actObj.cw = w;
				actObj.ch = h;

				actObj.scaleX = w / actObj.width;
				actObj.scaleY = h / actObj.height;

				var ih = img.naturalHeight;
				var iw = img.naturalWidth;

				var fw, fh;

				var width_ratio = w / iw;
				var height_ratio = h / ih;
				if (width_ratio > height_ratio) {
					fw = iw * width_ratio;
					fh = ih * fw / iw;
				} else {
					fh = ih * height_ratio;
					fw = iw * fh / ih;
				}

				if (width_ratio > height_ratio) {
					actObj.asw = actObj.cw = w / width_ratio;
					actObj.ash = actObj.ch = h / width_ratio;
				} else {
					actObj.asw = actObj.cw = w / height_ratio;
					actObj.ash = actObj.ch = h / height_ratio;
				}

				actObj.cx = 0;
				actObj.cy = 0;

				actObj.zoomBy(0, 0, 0, function() {

					actObj.setCoords();
					canvas.renderAll();

					$(".se-pre-con").fadeOut('slow');
					$("#AdduploadimageModal").modal('hide');

				});
			}
			img.src = imgpath;
			isReplaceImage = false;
		} else {
			fabric.util.loadImage(imgpath, function(img) {
				var object = new fabric.Cropzoomimage(img, {
					left: canvas.getWidth() / 2,
					top: canvas.getHeight() / 2,
					scaleX: canvasScale / 2,
					scaleY: canvasScale / 2
				});
				object.src = imgpath;
				canvas.add(object);
				canvas.setActiveObject(object);
				object.center();
				object.setCoords();
				setControlsVisibility(object);

				$(".se-pre-con").fadeOut('slow');
				$("#AdduploadimageModal").modal('hide');

				canvas.renderAll();
				saveState();
			}, {
				crossOrigin: ''
			});
		}
	}

	function addReplaceImage(object) {

		canvas.add(object);
		canvas.setActiveObject(object);
		canvas.renderAll();
	}

	$(document).on("click", ".bgImage", function() {
		var bgimagepath = $(this).data('imgsrc');
		setCanvasBg(canvas, bgimagepath);
		return false;
	});
	$(document).on("click", "#bgImageRemove", function() {
		deleteCanvasBg(canvas);
		return false;
	});
	$("#publishTemplate").click(function() {
		$("#publishModal").modal('show');
	});
	$(function() {
		$(".fzbutton").on("click", function() {
			var $button = $(this);
			var oldValue = $("#fontsize").val();
			if ($button.attr("id") == "fontsizeInc") {
				if (oldValue.toString().indexOf('.') != -1) {
					var newVal = Math.ceil(parseFloat(oldValue));
				} else {
					var newVal = parseFloat(oldValue) + 1;
				}
			} else {
				if (oldValue > 0) {
					if (oldValue.toString().indexOf('.') != -1) {
						var newVal = Math.floor(parseFloat(oldValue));
					} else {
						var newVal = parseFloat(oldValue) - 1;
					}
				} else {
					newVal = 0;
				}
			}
			$("#fontsize").val(newVal);
			$("#fontsize").change();
		});
	});
	$("#colorSelector").spectrum({
		showAlpha: false,
		showPalette: true,
		preferredFormat: "hex",
		hideAfterPaletteSelect: true,
		showInput: true,
		move: function(color) {
			var colorVal = color.toHexString(); // #ff0000
			changeObjectColor(colorVal);
			$('#colorSelector').css('backgroundColor', colorVal);
		},
	});
	$(function() {
		var $image = $('#imagetocrop');
		var cropBoxData;
		var canvasData;
		$('#crop_imagepopup').on('shown.bs.modal', function() {
			$image.cropper({
				autoCropArea: 0.5,
				built: function() {
					$image.cropper('setCanvasData', canvasData);
					$image.cropper('setCropBoxData', cropBoxData);
				}
			});
		}).on('hidden.bs.modal', function() {
			cropBoxData = $image.cropper('getCropBoxData');
			canvasData = $image.cropper('getCanvasData');
			$image.cropper('destroy');
		});
	});
	$("#bgcolorselect").spectrum({
		showAlpha: false,
		showPalette: true,
		flat: true,
		allowEmpty: true,
		hideAfterPaletteSelect: true,
		move: function(color) {
			var colorVal = color.toHexString(); // #ff0000
			deleteCanvasBg(canvas);
			setCanvasBg(canvas, false, colorVal);
		},
	});

	jQuery(function($) {
/*		$('#a').on('scroll', function() {
			if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
				if ($('#tempcat-select').val() != '') {
					getTemplates($('#tempcat-select').val());
				} else {
					getTemplates();
				}
			}
		});
*/		/*$('#c').on('scroll', function() {
			if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
				if ($('#cat-select').val() != '') {
					getcatimages($('#cat-select').val());
				} else {
					getcatimages();
				}
			}
		});*/
		$('#d').on('scroll', function() {
			if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
				if ($('#cat-select').val() != '') {
					getbgimages($('#bgcat-select').val());
				} else {
					getbgimages();
				}
			}
		});
	});
	var catoffset = 0;

	function getcatimages(id) {
		if (typeof id != 'undefined') {
			var catId = id;
		} else {
			var catId = '';
		}
		if (Iscatselected == false) {
			var lastelement = $('#catimage_container').children().last().attr('id');
			if (typeof lastelement != 'undefined') {
				catoffset = lastelement;
			}
		} else {
			catoffset = 0;
		}
		$.ajax({
			type: 'GET',
			url: 'get-catimages.php?offset=' + catoffset + '&limit=12&category=' + catId,
			success: function(data) {
				if (data != '') {
					$('#catimage_container').append(data);
					Iscatselected = false;
				} else {
					catoffset = 0;
				}
			}
		});
	}

	var bgoffset = 0;

	function getbgimages(id) {
		if (typeof id != 'undefined') {
			var bgcatId = id;
		} else {
			var bgcatId = '';
		}
		if (IsBgselected == false) {
			var lastbackground = $('#background_container').children().last().attr('id');
			if (typeof lastbackground != 'undefined') {
				bgoffset = lastbackground;
			}
		} else {
			bgoffset = 0;
		}
		$.ajax({
			type: 'GET',
			url: 'get-bgimages.php?offset=' + bgoffset + '&limit=12&category=' + bgcatId,
			success: function(data) {
				if (data != '') {
					$('#background_container').append(data);
					IsBgselected = false;
				} else {
					bgoffset = 0;
				}
			}
		});
	}

	var uploadimagesdata;

	function getuploadimages() {

		var $grid = $('#image_container');
		$grid.empty();

		$grid.isotope({
			itemSelector: '.thumb',
			masonry: {
				columnWidth: '.thumb'
			}
		});

		$.ajax({
			type: 'GET',
			url: 'get_uploadimages.php',
			success: function(data) {
				if (data != '') {
					uploadimagesdata = $(data);
					var data = $(data);

					$grid.isotope()
						.append(data)
						.isotope('appended', data)
						.isotope('layout');

					$grid.imagesLoaded().progress(function() {
						$grid.isotope('layout');
						$grid.isotope('reloadItems');
					});
				}
			}
		});
	}

	var tempoffset = 0;
	var templatesloading = false;

	function getTemplates(catid, refresh, tempid) {

		if (templatesloading) return;

		templatesloading = true;

		var $grid = $('#template_container');

		if (refresh) {
			$('#template_container').empty();
			tempoffset = 0;
		}

		$grid.isotope({
			itemSelector: '.thumb',
			masonry: {
				columnWidth: '.thumb'
			}
		});

		if (typeof catid === 'undefined') {
			catid = '';
			tempoffset = 0;
		}

		if (typeof tempid === 'undefined') {
			tempid = "";
		}

		if (Istempselected == false) {
			var lasttemplate = $grid.children().last().attr('id');
			if (typeof lasttemplate != 'undefined') {
				tempoffset = lasttemplate;
			}
		} else {
			tempoffset = 0;
		}

		$.ajax({
			type: 'GET',
			url: 'get_templates.php?offset=' + tempoffset + '&limit=12&catid=' + catid + '&refresh=' + refresh + '&tempid=' + tempid,
			cache: false,
			success: function(data) {
				if (data != '') {
					var data = $(data);

					$grid.isotope()
						.append(data)
						.isotope('appended', data)
						.isotope('layout');

					$grid.imagesLoaded().progress(function() {
						$grid.isotope('layout');
						$grid.isotope('reloadItems');
					});

					Istempselected = false;
				} else {
					tempoffset = 0;
				}

				templatesloading = false;
			}
		});
	}

	var textoffset = 0;

	function getTexts(id) {
        
        $('#text_container').empty();

		var $grid = $('#text_container');

		$grid.isotope({
			itemSelector: '.thumb',
			masonry: {
				columnWidth: '.thumb'
			}
		});
		if (typeof id != 'undefined') {
			var textid = id;
		} else {
			var textid = '';
		}
		if (IsTextselected == false) {
			var lasttext = $('#text_container').children().last().attr('id');
			if (typeof lasttext != 'undefined') {
				textoffset = lasttext;
			}
		} else {
			textoffset = 0;
		}
		$.ajax({
			type: 'GET',
			url: 'get_texts.php?offset=' + textoffset + '&limit=12&textid=' + textid,
			success: function(data) {
				if (data != '') {

					$grid.isotope()
						.append(data)
						.isotope('appended', data)
						.isotope('layout');

					IsTextselected = false;
				} else {
					textoffset = 0;
				}
			}
		});
	}
	$(document).ready(function() {
		$('#canvaswhForm').validate({
			rules: {
				loadCanvasWid: {
					required: true,
					number: true
				},
				loadCanvasHei: {
					required: true,
					number: true
				},
				numOfcanvasrows: {
					required: true,
					number: true
				},
				numOfcanvascols: {
					required: true,
					number: true
				},
			},
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				element.text('').addClass('valid')
					.closest('.form-group').removeClass('has-error').addClass('has-success');
				element.remove('label');
			},
			submitHandler: function(form) { // <- only fires when form is valid
				addNewCanvasPage();
				setCanvasSize();
			}
		});
	});

	function handleFileSelect(evt) {
		$("ul.navbar-nav>li.dropdown").removeClass("open");
		var files = evt.target.files; // FileList object
		for (var i = 0, f; f = files[i]; i++) {
			if (f.name.indexOf('.ype') == -1) {
				continue;
			}
			var reader = new FileReader();
			reader.onload = (function(theFile) {
				return function(e) {
					openTemplate(e.target.result);
				};
			})(f);
			reader.readAsText(f);
		}
	}
	//document.getElementById('templateselect').addEventListener('change', handleFileSelect, false);
	$('#templateselect').on('change', handleFileSelect);
	$("#showmoreoptions").click(function() {
		$("#opacitySlider").hide();
		$("#lineheightSlider").hide();
        $("#charspacingSlider").hide();
		$('#showmoreoptions ul li a').removeClass('temphide');
		var activeObject = canvas.getActiveObject();
		if (activeObject) {
			if (activeObject.lockMovementY == true) {
				$('#objectlock').html("<i class='fa fa-unlock'></i>&nbsp; Unlock Object");
			} else {
				$('#objectlock').html("<i class='fa fa-lock' style='font-size:16px;'></i>&nbsp;&nbsp; Lock Object");
			}
			var objectopacity = activeObject.getOpacity();
			$("#changeopacity").slider('setValue', objectopacity);
		}
	});
	$("#objectopacity").click(function() {
		$("#opacitySlider").toggle();
		$("#showmoreoptions ul li a").each(function() {
			if ($(this).css("display") == "block") {
				$(this).not("#objectopacity").addClass('temphide');
			}
		});
	});
	$("#lineheight").click(function() {
		$("#lineheightSlider").toggle();
		$("#showmoreoptions ul li a").each(function() {
			if ($(this).css("display") == "block") {
				$(this).not("#lineheight").addClass('temphide');
			}
		});
	});
    $("#charspacing").click(function() {
        $("#charspacingSlider").toggle();
        $("#showmoreoptions ul li a").each(function() {
            if ($(this).css("display") == "block") {
                $(this).not("#charspacing").addClass('temphide');
            }
        });
    });
	$('#changeopacity').slider({
		formatter: function(value) {
			return value * 100 + '%';
		}
	});
	$('#bgscale').slider({
		formatter: function(value) {
			return value * 100 + '%';
		}
	});

	function handleContextmenu(e) {
		e.preventDefault();
		$(".custom-menu").finish().toggle(100).
		css({
			top: e.pageY + "px",
			left: e.pageX + "px"
		});
	}
	$("#canvasbox-tab").bind('contextmenu', function(e) {
		handleContextmenu(e);
		return false;
	});
	$(".custom-menu li").click(function() {
		switch ($(this).attr("data-action")) {
			case "selectall":
				selectallobjs();
				break;
			case "copy":
				copyobjs();
				break;
			case "cut":
				cutobjs();
				break;
			case "paste":
				pasteobjs();
				break;
		}
		$(".custom-menu").hide(100);
	});
	$(document).off('click.tab.data-api');
	$(document).on('click.tab.data-api', '[data-toggle="tab"]', function(e) {
		e.preventDefault();
		var tab = $($(this).attr('href'));
		var activate = !tab.hasClass('active');
		$('div.tab-content>div.tab-pane.active').removeClass('active');
		$('ul.nav.nav-tabs>li.active').removeClass('active');
		if (activate) {
			$(this).tab('show')
		}
        $("#leftsection").css("width","120px");
	});

	$(document).unbind('keydown').bind('keydown', function(event) {
		var doPrevent = false;
		if (event.keyCode === 8) {
			var d = event.srcElement || event.target;
			if ((d.tagName.toUpperCase() === 'INPUT' &&
					(
						d.type.toUpperCase() === 'TEXT' ||
						d.type.toUpperCase() === 'PASSWORD' ||
						d.type.toUpperCase() === 'FILE' ||
						d.type.toUpperCase() === 'SEARCH' ||
						d.type.toUpperCase() === 'EMAIL' ||
						d.type.toUpperCase() === 'NUMBER' ||
						d.type.toUpperCase() === 'DATE')
				) ||
				d.tagName.toUpperCase() === 'TEXTAREA') {
				doPrevent = d.readOnly || d.disabled;
			} else {
				doPrevent = true;
			}
		}

		if (doPrevent) {
			event.preventDefault();
		}
	});
	$(function() {
		$("#shapeslider").slider({
			"min": 0.25,
			"max": 1.25,
			"value": 1,
			"step": 0.05,
			orientation: "horizontal"
		});
		$("#shapeslider").slider({
			stop: function(event, ui) {
				var spaceopacity = $("#shapeslider").slider("value");
				var obj = canvas.getActiveObject();
				if (obj) {
					obj.setOpacity(spaceopacity);
				}
				canvas.renderAll();
			}
		});
	});
	$(function() {
		$("#shapeslider").slider();
	});

	$("#upload_image").click(function() {
		var $grid = $('#image_container');
		$grid.imagesLoaded().progress(function() {
			$grid.isotope('layout');
			$grid.isotope('reloadItems');
		});
		$('#AdduploadimageModal').modal({
			show: true
		});
	});

	$('#AdduploadimageModal').on('shown.bs.modal', function(e) {
		var $grid = $('#image_container');

		$grid.imagesLoaded().progress(function() {
			$grid.isotope('layout');
			$grid.isotope('reloadItems');
		});
	});
	var uploadIdToDel = '';
	$(document).on("click", ".deleteUploadImg", function() {
		uploadIdToDel = $(this).attr('id');
		proceed_uploadimgDelete();
	});

	function proceed_uploadimgDelete() {
		var selectedimg = uploadIdToDel;
		if (selectedimg != '') {
			$.post("actions/deleteimg.php", {
				"imgid": selectedimg
			}, function(data) {
				$('#image_container').empty();
				getuploadimages();
			});
		} else {}
	}

	function setDragMode(mode) {
		$('#imagetocrop').cropper('setDragMode', mode);
	}

	function zoom(val) {
		$('#imagetocrop').cropper('zoom', val);
	}

	function move(val1, val2) {
		$('#imagetocrop').cropper('move', val1, val2);
	}

	function rotate(val) {
		$('#imagetocrop').cropper('rotate', val);
	}

	function scaleX(val) {
		$('#imagetocrop').cropper('scaleX', val);
	}

	function scaleY(val) {
		$('#imagetocrop').cropper('scaleY', val);
	}

	function crop(mode) {
		$('#imagetocrop').cropper('crop', mode);
	}

	function clear(mode) {
		$('#imagetocrop').cropper('clear', mode);
	}

	function disable(mode) {
		$('#imagetocrop').cropper('disable', mode);
	}

	function enable(mode) {
		$('#imagetocrop').cropper('enable', mode);
	}

	function reset(mode) {
		$('#imagetocrop').cropper('reset', mode);
	}

	$("#getCroppedCanvas").click(function() {

		var cropcanvas = $('#imagetocrop').cropper('getCroppedCanvas');

		$(".se-pre-con").fadeIn('slow');
		$("#crop_imagepopup").modal('hide');
		// Upload cropped image to server if the browser supports `HTMLCanvasElement.toBlob`
		cropcanvas.toBlob(function(blob) {

			console.log(blob);

			var currentTime = new Date();
			var month = currentTime.getMonth() + 1;
			var day = currentTime.getDate();
			var year = currentTime.getFullYear();
			var hours = currentTime.getHours();
			var minutes = currentTime.getMinutes();
			var seconds = currentTime.getSeconds();
			var filename = month + '' + day + '' + year + '' + hours + '' + minutes + '' + seconds + ".png";

			var data = new FormData();
			data.append('file', blob);
			data.append('filename', filename);

			$.ajax({
				type: 'POST',
				url: 'savecropimage.php',
				data: data,
				contentType: false,
				processData: false,
				success: function(msg) {
					console.log('Upload success');

					var actObj = canvas.getActiveObject();

					if (!actObj) {
						$(".se-pre-con").fadeOut('slow');
						return;
					}
					//replace image
					var img = new Image();
					img.onload = function() {
						var w = actObj.width * actObj.scaleX;
						var h = actObj.height * actObj.scaleY;
						actObj.setElement(img);

						scalex = w / this.width;
						scaley = h / this.height;

						actObj.scaleX = scalex;
						actObj.scaleY = scalex;

						actObj.orgSrc = img.src;
						actObj.src = img.src;

						$(".se-pre-con").fadeOut('slow');
						actObj.setCoords();
						canvas.renderAll();
					}
					img.src = msg;
				}
			})
		});
	});

	$(document).ready(function() {
		var files;
		$('#element_file').on('change', prepareUpload);

		function prepareUpload(event) {
		    files = event.target.files;
			//$("#loadingpage").modal('show');
			uploadimage();
		}

		function uploadimage() {
		    var uploadata = new FormData();
		    $.each(files, function(key, value) {
		        uploadata.append("element_file", value);
		    });
		    $.ajax({
		        url: 'fontfile.php?files',
		        type: 'POST',
		        data: uploadata,
		        cache: false,
		        dataType: 'json',
		        processData: false,
		        contentType: false,
		        success: function(data) {
		        },
				 error:function() {
					 // $("#loadingpage").modal('hide');
				 }
		    });
		}

	});

	$(document).ready(function() {
		$('#addfontformodal').validate({
			rules: {
				element_file: {
					required: true,
				},
				myCheckboxes: {
					required: true,
                     minlength: 1
				},
			},
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				element.text('').addClass('valid')
					.closest('.form-group').removeClass('has-error').addClass('has-success');
				element.remove('label');
			},
			submitHandler: function(form) {
				var newimage = $("#element_file").val();
				newimage = newimage.replace(/^.*\\/, "");
				var imagepath = newimage;
                $.post(
                    "./actions/addfontform.php", {
						"addimage": imagepath
                    },
                    function(data) {
						$("#AdduploadfileModal").modal('hide');
                        document.getElementById("successMessage").innerHTML = data;
                        $('#successModal').modal('show');
                    }
                );
            }
		});
	});

    $(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");;
    });
    
    $(document).ready(function() {
        $('#donwloadlimitmodal').validate({
            rules: {
                pdflimit: {
                    required: true,
                },
                jpeglimit: {
                    required: true,
                },
                pnglimit: {
                    required: true,
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            success: function(element) {
                element.text('').addClass('valid')
                    .closest('.form-group').removeClass('has-error').addClass('has-success');
                element.remove('label');
            },
            submitHandler: function(form) {
                var pdflimits = $("#pdflimit").val();
                var jpeglimist = $("#jpeglimit").val();
                var pnglimits = $("#pnglimit").val();
                $.post(
                    "./actions/savedownload.php", {
                        "res_pdf": pdflimits,
                        "res_jpeg": jpeglimist,
                        "res_png": pnglimits
                    },
                    function(data) {
                        document.getElementById("successMessage").innerHTML = data;
                        $('#successModal').modal('show');
                    }
                );
            }
        });
    });
</script>
</html>