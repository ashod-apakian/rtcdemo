<?php

 if(1) { error_reporting(E_ALL&~E_NOTICE); }
 else  { error_reporting(E_NONE); }

 if(empty($_SERVER['HTTPS'])||$_SERVER['HTTPS']==="off")
  {
  header('HTTP/1.1 301 Moved Permanently');
  header('Location: '.'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  die();
  }


 $req=$_SERVER['REQUEST_URI'];
 if(substr($req,-1)=='/') { $req=substr($req,0,-1); }
 $pre=strtok($req,'?');
 $qry=substr($req,strpos($req,"?")+1);
 $slf=(isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']==='on'?"https":"http")."://".$_SERVER[HTTP_HOST].$req."".$qry;
 $fil=ltrim($pre,"/");
 $fil=str_replace('/','_',$fil);
 //$fil.=".php";

 $filw=$fil.".wiki";
 $filp=$fil.".php";



 $vvv=round(microtime(true)*1000);
 $vvv=$vvv%10000;
 $vvv=abs($vvv);
 $vvv=$vvv+10000;


 $site_name="";
 $logo_path="";
 $site_desc="";
 $site_titl="";



 function head ($sn,$diz,$st,$lp)
 {
 global $site_titl;
 global $site_name;
 global $logo_path;
 global $site_desc;
 $site_name=$sn;
 $logo_path=$lp;
 $site_desc=$diz;
 $site_titl=$st;
 $tit=$site_name." | ".$site_titl;
 $out="";
 $out.="<!doctype html>\n";
 $out.="<html lang='en' translate='no'>\n";
 $out.="<head>\n";
 $out.="<meta charset='UTF-8'>\n";
 $out.="<title>";
 $out.=$tit;
 $out.="</title>\n";
 $out.="<meta     name='viewport'                              content='width=device-width, initial-scale=1' />\n";
 $out.="<meta name='google'           content='notranslate' />\n";
 $out.="<meta name='theme-color'      content='#142f7f'       media='(prefers-color-scheme: light)'>\n";
 $out.="<meta name='theme-color'      content='#142f7f'       media='(prefers-color-scheme: dark)'>\n";
 //$out.="<meta     name='theme-color'                           content='#ffff4f'/>\n";
 $out.="<meta property='og:title'                              content='".$tit."'>\n";
 $out.="<meta property='og:description'                        content='".$site_desc."'>\n";
 $out.="<meta property='og:image'                              content='".$logo_path."/logo200.png'>\n";
 $out.="<meta property='og:site_name'                          content='".$site_name."'>\n";
 $out.="<meta property='og:type'                               content='website'>\n";
 $out.="<meta     name='description'                           content='".$site_desc."'>\n";
 $out.="<meta     name='mobile-web-app-capable'                content='yes'>\n";
 $out.="<meta     name='apple-mobile-web-app-capable'          content='yes'>\n";
 $out.="<meta     name='apple-mobile-web-app-status-bar-style' content='#ffff40'>\n";
 $out.="<link rel='icon' type='image/png'            href='".$logo_path."/logo32.png'>\n";
 $out.="<link rel='apple-touch-icon'                 href='".$logo_path."/logo152.png'>\n";
 $out.="<link rel='apple-touch-icon' sizes='76x76'   href='".$logo_path."/logo76.png'>\n";
 $out.="<link rel='apple-touch-icon' sizes='120x120' href='".$logo_path."/logo120.png'>\n";
 $out.="<link rel='apple-touch-icon' sizes='152x152' href='".$logo_path."/logo152.png'>\n";
 $out.="<meta http-equiv='cache-control' content='no-cache, must-revalidate, post-check=0, pre-check=0' >\n";
 $out.="<meta http-equiv='cache-control' content='max-age=0'>\n";
 $out.="<meta http-equiv='expires'       content='0'>\n";
 $out.="<meta http-equiv='expires'       content='Tue, 01 Jan 1980 1:00:00 GMT'>\n";
 $out.="<meta http-equiv='pragma'        content='no-cache'>\n";
 $out.="<style type='text/css'>\n";
 $out.="a      { text-decoration: none; color: #009; }\n";
 $out.="a:hover{ text-decoration: none; color: #44f; }\n";
 //$out.=".menoo { z-index: 999999; position: absolute; top: 0px; left: 0px; width: 80px; height: 80px; background: #aa0; }\n";
 //$out.="*      { overflow:hidden; background:none; margin:0; padding:0; border:none;  outline:0;  width:100%;  height:100%;   }\n";
 $out.="html   { overflow:hidden; background:none; margin:0; padding:0; border:none;   position:fixed;    top:0px; left:0px; width:100%; height:100%; -webkit-user-select:none; -moz-user-select:none; -ms-user-select:none; user-select:none; }\n";
 $out.="body   { overflow:hidden; background:#49a; margin:0px; padding:0px; border:none;   position:fixed; top:0px; left:0px; width:100%; height:100%; -webkit-user-select:none; -moz-user-select:none; -ms-user-select:none; user-select:none; }\n";
 //$out.="canvas { overflow:hidden; background:none; }\n";
 //$out.="video  { overflow:hidden; }\n";
 $out.="video  { background: #2562db; }\n";
 $out.=".wra   { white-space: pre-wrap; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap; word-wrap: break-word; }\n";
 $out.="</style>\n";
 $out.="</head>\n";
 //$out.="<body id='bodid'></body>\n";
 echo $out;
 }


 function navStyle ()
 {
 $out="";
 $out.="<style type='text/css'>\n";
 $out.=".navbar         {  overflow: hidden;  background-color: #ffffff;  position: fixed;  height:50px; top: 0;  width: 100%; border-bottom:2px solid blue; }\n";
 $out.=".navbar a       {    color: #5092cf;    font-family:arial; text-decoration: none;  font-size: 40px;}\n";
 $out.=".navbar a:hover {  background: #c0e2ff;  color: #5092cf;}\n";
 $out.=".navbar span    {    color: #5092cf;    font-family:arial; text-decoration: none;  font-size: 40px;}\n";
 $out.="html   { overflow:auto; background:none; margin:0; padding:0; border:none;   position:fixed;    top:0px; left:0px; width:100%; height:100%; -webkit-user-select:none; -moz-user-select:none; -ms-user-select:none; user-select:none; }\n";
 $out.="body   { font-family:arial; overflow:auto;  background:#49a; margin:0px; padding:0px; border:none;   position:fixed; top:0px; left:0px; width:100%; height:100%; -webkit-user-select:none; -moz-user-select:none; -ms-user-select:none; user-select:none; }\n";
 $out.="</style>\n";
 echo $out;
 }



 function codeStyle ()
 {
 $out="";
 $out.="<style type='text/css'>\n";
 $out.="pre                       { background: white;       padding: 1rem}\n";
 $out.="img                       { height: auto;    max-width: 100%; margin:0; padding:0;}\n";
 $out.="textarea                  { border: 0;    padding: 0;    margin: 0;    font-style: none; background: #393939; color: #fff; font-size: 9px; font-family: consolas; }\n";
 $out.="blockquote                { border-left: 10px solid grey;    padding: 0.25rem 0.5rem;    margin-left: 0;    font-style: italic}\n";
 $out.="p code,li code            { background-color: #f5f5f5;       white-space: pre-wrap;    padding: 5px;    border-radius: 5px;    font-size: 0.85rem;    box-shadow: 0 1px 3px rgba(0,0,0,0.1),0 1px 1px rgba(0,0,0,0.1),0 2px 1px -1px rgba(0,0,0,0.12)}\n";
 $out.="pre code .special-num      {    color:#ffc292;}\n";
 $out.="pre code .string1          {    color:#A1E46D;}\n";
 $out.="pre code .string2          {    color:#a1c4cD;}\n";
 $out.="pre code .special1         {    color:#D6665D;}\n";
 $out.="pre code .special2         {    color:#36c6cD;}\n";
 $out.="pre code .special3         {    color:#f6c61D;}\n";
 $out.="pre code .special4         {    color:#c962cD;}\n";
 $out.="pre code .special-js       {    color:#6DE4D1;}\n";
 $out.="pre code .special-js-glob  {    color:#A1E46D;    font-weight:bold;}\n";
 $out.="pre code .special-comment  {    color:#aaa;}\n";
 $out.="pre code .special-js-meth  {    color:#E46D8A;}\n";
 $out.="pre code .special-html     {    color:#E4D95F;}\n";
 $out.="pre code .special-sql      {    color:#1D968C;}\n";
 $out.="pre code .special-php      {    color:#597EA7;}\n";
 $out.="</style>\n";
 echo $out;
 }



 function showFileCode ($filename)
 {
 echo "<p><code style='color:#000;'>".$filename."</code></p>";
 echo "<pre style=\"background-color:#2b303b;color:#c0c5ce;\" >";
 echo "<code>\n";
 echo "<script type='text/javascript'>\n";
 echo "alt=null;\n";
 echo "linu=0;\n";
 echo "var now = new Date;\n";
 echo "readTextFile(\"".$filename."?\"+now.getTime());\n";
 echo "var ry=alt.toString().split(\"\\n\");\n";
 echo "for(i=0;i<ry.length;i++) { repit(ry[i]); } ";
 echo "</script>\n";
 echo "</code>";
 echo "</pre>";
 }


 function showTextCode ($title,$code)
 {
 echo "<p><code style='color:#000;'>".$title."</code></p>";
 echo "<pre style=\"background-color:#2b303b;color:#c0c5ce;\" >";
 echo "<code>\n";
 echo "<script type='text/javascript'>\n";
 echo "alt=".$code.";\n";
 echo "linu=0;\n";
 //echo "var now = new Date;\n";
 //echo "readTextFile(\"".$filename."?\"+now.getTime());\n";
 //echo "var ry=alt.toString().split(\"\\n\");\n";
 echo "var ry=alt.split(\"\\n\");\n";
 echo "for(i=0;i<ry.length;i++) { repit(ry[i]); } ";
 echo "</script>\n";
 echo "</code>";
 echo "</pre>";
 }

 function echoScript  ($sf)
 {
 echo "<script type='text/javascript' src='".$sf."'></script>\n";
 }


 function scriptOpen ()
 {
 $out="";
 $out.="<script type='text/javascript'>\n";
 echo $out;
 }



 function scriptClose ()
 {
 $out="";
 $out.="</script>\n";
 echo $out;
 }






 ///function head3 ($salt) { $out=""; $out.="<link rel='manifest' href='https://apakian.online/manifest.json?".$salt."' >\n"; echo $out; }
//echoScript("https://apakian.online/aa_Js.js?".$vvv);
//echo $req;
//scriptOpen();
//scriptClose();

/*
 function scriptOpen ()
 {
 $out="";
 $out.="<script type='text/javascript'>\n";
 echo $out;
 }



 function scriptClose ()
 {
 $out="";
 $out.="</script>\n";
 echo $out;
 }




 function echoScript  ($sf)
 {
 echo "<script type='text/javascript' src='".$sf."'></script>\n";
 }



 function ezyDump ()
 {
 global $req,$qry,$slf,$pre;
 //$fil="";
 //echo $req; echo "<br>";
 //echo $qry; echo "<br>";
 //echo $slf; echo "<br>";
 //echo $pre; echo "<br>";
 //$fil=ltrim($pre,"/");
 //echo $fil;
 //echo str_replace('/', '_', $pre);
 }

 */
