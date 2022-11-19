<!-- subject: Simple aa_js demo -->
<!-- date: 2022/11/18&nbsp; 20:32 -->
<?php
 head("Apakian Online","Blog of Ashod Apakian","Simple aa_js demo","https://apakian.online/logos");
 echo "<body id='bodid'>\n";
 echo "</body>\n";
 echoScript("https://apakian.online/core/aa_Js.js?".$vvv);
?>
<script type='text/javascript'>

//-----------------------------------------------------------------------

 var cfg_app_version="0.06";
 var cfg_app_speed=30;

 var cfg_peers_max=4;

 var cfg_profiler_use=0;
 var cfg_profiler_guix_use=0;
 var cfg_profiler_ptr_use=1;
 var cfg_profiler_media_use=1;
 var cfg_profiler_beam_use=1;

 var cfg_room_name="lobby";

 var cfg_chatpix_width=160;
 var cfg_chatpix_height=120;

 var cfg_cam_res_wid=320;
 var cfg_cam_res_short=false;
 var cfg_cam_res_rot=false;

 var cfg_audio_script_processor_size=2048;
 var cfg_audio_fft_size=128;
 var cfg_audio_max_db=-30;
 var cfg_audio_min_db=-120;
 var cfg_audio_analysis_cycle=3;
 var cfg_audio_threshold=120;
 var cfg_audio_default_gain=3.5;

 var cfg_audio_local_initially_muted=true;
 var cfg_audio_peer_initially_muted=false;
 var cfg_audio_loopback_muted=true;

 var cfg_sdp_manip=false;
 var cfg_sdp_sbool=true;//true;
 var cfg_sdp_max_arate=(8);  // between 8-256
 var cfg_sdp_max_vrate=(1024); // between 8-1024

 var cfg_sdp_change_bitrate=true;
 var cfg_sdp_use_arate=(64);
 var cfg_sdp_use_vrate=(384);

 var cfg_v_fps=30;
 var cfg_a_aec=true;
 var cfg_a_nsu=false;
 var cfg_a_agc=true;

 var cfg_spot_show=false;

//-----------------------------------------------------------------------

 window.onload=function()  {  aa.mainStart(cfg_app_version,cfg_app_speed,appProc);  aa.mainRun();  };

 var app=aa.main_vars.app;

//-----------------------------------------------------------------------





 function appStart ()
 {
 var ret;
 if(cfg_profiler_use)
  {
  aaProfilerGroupsSet("All",1);
  aaProfilerStart();
  }
 app.is_home=true;
 app.in_call=true;
 app.options={};
 app.options.aud_act=true;
 app.options.auto_hello=true;
 app.options.fx_censor=false;
 app.options.fx_darken=false;
 app.options.fx_brighten=false;
 app.options.fx_disco=false;
 app.cpu_speed=0;
 app.ei=aa.envInfoGet();
 //console.log(app.ei);
 aa.envCpuMonitorBegin(12);
 }






 function appYield ()
 {
 var str,lines,i;
 if(app.cpu_speed==0)
  {
  app.cpu_speed=aa.envCpuMonitorGet();
  }
 if(app.cpu_speed!=0)
  {
  if(1&&aa_profiler.is_started&&aa.mainCyclePulse(110))
   {
   str=aaProfilerDump(0,100,200,20000000,1,2,1);
   if(str!=false)
    {
    lines=str.split(/\r\n|\r|\n/);
    if(1&&lines.length>2)  {   console.log(" ");  for(i=0;i<lines.length;i++) { console.log(lines[i]);    }    }
    }
   }
  }
 }







 function appProc ()
 {
 var j,i,s;
 var vg,va,gg,ga;
 var xx,yy,fs,fnt;
 var grp;


 switch(aa.main_state.stage)
  {
  case 0:
  appStart();
  aa.mainStageSet(20);
  break;

  case 20:
  if(app.cpu_speed==0) { break; }
  console.log("cpu speed = "+app.cpu_speed);
  guixStart();
  ptrStart();
  aa.mainStageSet(25);
  break;


  case 25:
  if(aa.iface_obj.blit_counter==0) { break; }
  beamStart();
  ///app.waze=aa.mainWasmLoad("https://apakian.online/core/wasm.wasm?"+aa.numRand(12101000),256);
  aa.mainStageSet(30);
  break;


  case 30:
  mediaStart();
  aa.mainStageSet(40);
  break;


  case 40:
  s=Math.floor(Date.now()/10000);
  app.sprite=aa.spriteLoad("https://apakian.online/sprites/sprite_sheet.png?"+s);
  aa.mainStageSet(50);
  break;


  case 50:
  for(j=0;j<8;j++)
   {
   aa.spriteStatus(app.sprite);
   if(app.sprite.is_ready==true) { break; }
   }
  if(app.sprite.is_ready!=true) { break; }
  console.log("took "+aa.timerMsRunning()+"  "+app.sprite.sheet_map.length+"  sprites loaded");
  aa.mainStageSet(55);
  break;


  case 55:
  /*
  if(app.waze.is_ready!=true) { break; }
  if(1)
   {
   console.log("waze loeded "+aa.timerMsRunning()+"  exports="+app.waze.export_ray.length+"  imports="+app.waze.import_ray.length);
   for(i=0;i<app.waze.export_ray.length;i++)  { console.log("export "+i+"/"+app.waze.export_ray.length+"  "+app.waze.export_ray[i].kind+"  "+app.waze.export_ray[i].name);   }
   for(i=0;i<app.waze.import_ray.length;i++)  { console.log("import "+i+"/"+app.waze.import_ray.length+"  "+app.waze.import_ray[i].kind+"  "+app.waze.import_ray[i].name);   }
   }
   */
  aa.mainStageSet(60);
  break;




  case 60:
  aa.mainStageSet(100);
  break;



  case 100:
  app.media.devenu=aa.mediaDeviceEnumerator();
  aa.mainStageSet(120);
  break;


  case 120:
  if(app.media.devenu.is_failed==true) { aa.debugAlert(); aa.mainStageSet(666); break; }
  if(app.media.devenu.is_ready!=true)  { break; } //aa.debugAlert("ready="+app.media.devenu.is_ready); break; }
  console.log("mainStage 120 , device enumerator completed");
  if(app.media.devenu.vid_input==true&&app.media.devenu.aud_input==true)
   {
   //mediaDeviceDump(false);
   mediaDeviceListInit(app.media.devenu);
   aa.mainStageSet(170);
   break;
   }
  aa.mainStageSet(130);
  break;



  case 130:
  app.media.handle=aa.mediaCreate({},{});
  aa.mainStageSet(140);
  break;




  case 140:
  aa.mediaStatus(app.media.handle);
  med=aa.mediaGet(app.media.handle);
  if(med.res=="err")
   {
   err=aa.mediaErrorEtc(med.e_name,med.e_msg);
   alert("stage 140, err="+err);
   switch(err)
    {
    case 44: console.log("permission denied"); break;
    case 46: console.log("permission dismissed"); break;
    default: console.log("aerr = "+err+"  "+med.e_name+"  "+med.e_msg); break;
    }
   aa.mainStageSet(666);
   break;
   }
  if(med.res=="ok")
   {
   if(med.stage!=300) { aa.debugAlert(med.stage); }
   if(aa.mediaDestroy(app.media.handle)!=true) {  aa.debugAlert(); }
   app.media.handle=0;
   aa.mainStageSet(160);
   break;
   }
  break;



  case 160:
  aa.mainStageSet(100);
  break;


  case 170:
  aa.mainStageSet(200);
  //aa.mainStageSet(180);
  break;


  case 180:
  grp=guixGroupGet("b_vippy_0");
  aa.videoLoad(grp.han,true,"https://apakian.online/vids/01.mp4");
  grp.dom.loop=true;
  aa.mainStageSet(185);
  break;


  case 185:
  grp=guixGroupGet("b_vippy_0");
  if(grp.vars.is_failed)  { aa.debugAlert(); }
  app.vs=aa.videoStatus(grp.han);
  if(app.vs.can_play!=true)   { break; }
  aa.videoMuteSet(grp.han,false);
  aa.videoPlay(grp.han);
  //           app.cst=grp.dom.captureStream();
  //app.cst_vt=app.cst.getVideoTracks();
  //app.cst_at=app.cst.getAudioTracks();
  //app.cst_vt=grp.dom.getVideoTracks();
  //app.cst_at=grp.dom.getAudioTracks();
  console.log(grp.obj.id);
  aa.mainStageSet(200);
  break;



  case 200:
  app.media.handle=mediaPairCreate(app.media.cur_axi,app.media.cur_vxi);
  aa.mainStageSet(220);
  break;




  case 220:
  aa.mediaStatus(app.media.handle);
  med=aa.mediaGet(app.media.handle);
  if(med==null) { break; }
  if(med.res==="err")
   {
   console.log("EERRRRRR");
   err=aa.mediaErrorEtc(med.e_name,med.e_msg);
   switch(err)    {    default: alert("berr = "+err+"  "+med.e_name+"  "+med.e_msg); break;    }
   aa.mainStageSet(666);
   break;
   }
  if(med.res!=="ok")  { break; }
  if(med.stage!=300)  { break; }

  if((grp=aa.guiGroupGetById("b_video_0"))==null) { aa.debugAlert(); }
  ///if((grp=aa.guiGroupGetById("b_vippy_0"))==null) { aa.debugAlert(); }
  aa.mediaAttach(app.media.handle,grp.han);
  if(cfg_audio_loopback_muted==true)   {   grp.dom.muted=true;    grp.dom.volume=0;   }
  else                                 {   grp.dom.muted=false;   grp.dom.volume=1;   }
  if(med.res!="ok")
   {
   console.log(med.e_name);
   console.log(med.e_msg);
   console.log(med.e_code);
   console.log(med.e_etc0);
   console.log(med.e_etc1);
   }
  eob=aa.mediaErrObjCreate(med.res,med.e_name,med.e_msg,med.e_code);
  console.log(eob);
  mediaDeviceListErr(app.media.active_devenu,"videoinput",app.media.cur_vxi,eob);//app.media.cur_axi,err);
  mediaDeviceListErr(app.media.active_devenu,"audioinput",app.media.cur_axi,eob);//app.media.cur_axi,err);
  aa.mainStageSet(240);
  break;




  case 240:
  mediaDeviceSwapperInit();
  aa.mainStageSet(260);
  break;


  case 260:
  mediaLocalGainMuteSet(cfg_audio_default_gain,cfg_audio_local_initially_muted);
  guixNeedsPaintSet(null);
  aa.mainStageSet(270);
  aa.mainStageSet(300);
  break;

  case 270:
  guixRoomEntry(null);
  aa.mainStageSet(275);
  break;

  case 275:
  break;



  case 300:
  console.log("CONNECTING");
  ///app.beam.sh1=beamNew("vidcalls",cfg_peers_max,"",cfg_room_name,"wss://mebeam.com:443/wss/roomer");
  app.beam.sh1=beamNew("vidcalls",cfg_peers_max,"",cfg_room_name,"wss://apakian.online:443/wss/roomer");
  aa.mainStageSet(303);
  break;



  case 303:
  aa.mainStageSet(400);
  break;




  case 400:
  case 401:
  ///if(app.sii>=0&&aa.mainCyclePulse(27))   {     guixNeedsPaintSet(null);     }
  if(app.beam.sh1.sock_status.is_closed==true||app.beam.sh1.sock_status.is_error==true)
   {
   if(app.beam.sh1.sock_status.is_open==true) { console.log("disconnected "); }
   else                                       { console.log("could not connect"); }
   alert("Room is full");
   aa.mainStageSet(450);
   }
  if(aa.main_state.stage==400&&app.beam.sh1.sock_status.is_open==true)
   {
   if(app.beam.sh1.sock_status.is_closed==false&&app.beam.sh1.sock_status.is_error==false)
    {
    if(app.beam.sh1.is_ready==true)
     {
     guixTopbarPaint(guixGroupGet("b_topbar_0"));
     aa.debugClear(5);
     aa.mainStageSet(401);
     break;
     }
    }
   }
  break;




  case 450:
  console.log("RE-CONNECTING");
  beamDelete(app.beam.sh1);
  //app.beam.sh1=beamNew("vidcalls",cfg_peers_max,"",cfg_room_name,"wss://mebeam.com:443/wss/roomer");
  app.beam.sh1=beamNew("vidcalls",cfg_peers_max,"",cfg_room_name,"wss://apakian.online:443/wss/roomer");
  aa.mainStageSet(400);
  break;


  case 500:
  break;
  }


 appYield();
 ///aa.mainWasmStatus(app.waze);
 ptrYield();
 mediaYield();
 if(app.beam!==undefined)  {  beamYield(app.beam.sh1);  }
 }




//-----------------------------------------------------------------------





 function guixStart ()
 {
 var i,dsz;
 app.guix={};
 app.guix.group_ray=[];
 app.guix.font_ray=[];
 app.guix.fonts_ready=false;
 app.guix.widget_ray=[];
 guixPixelsPerPcUpdate();
 guixCreate("canstream","b_canstream_0",8350,guixMsgProc);
 for(i=0;i<cfg_peers_max;i++)
  {
  guixCreate("video","b_video_"+i,8350,guixMsgProc);
  }
 document.getElementsByTagName("html")[0].style.touchAction="none";
 document.getElementsByTagName("html")[0].style.pointerEvents="none";
 document.getElementsByTagName("body")[0].style.touchAction="none";
 document.getElementsByTagName("body")[0].style.pointerEvents="none";
 document.getElementsByTagName("html")[0].touchAction="none";
 document.getElementsByTagName("html")[0].pointerEvents="none";
 document.getElementsByTagName("body")[0].touchAction="none";
 document.getElementsByTagName("body")[0].pointerEvents="none";
 guixCreate("canvas","b_topbar_0",9300,guixMsgProc);

 guixCreate("canvas","b_animlay_0",9970,guixMsgProc);
 guixCreate("canvas","b_virtlay_0",9980,guixMsgProc);
 app.guix.lense=aa.guiLenseNew("hudlay","b_virtlay_0","b_animlay_0",guixLensePaintProc);
 app.guix.lense.vars.rows=20;
 app.guix.lense.vars.line=[];
 for(i=0;i<app.guix.lense.vars.rows;i++)  {  app.guix.lense.vars.line[i]="";  }

 guixCreate("canvas","b_animlay_1",9950,guixMsgProc);
 guixCreate("canvas","b_virtlay_1",9960,guixMsgProc);
 app.guix.slide=aa.guiLenseNew("slidelay","b_virtlay_1","b_animlay_1",guixLensePaintProc);
 app.guix.slide.vars.cur_section=0;
 //app.guix.slide.vars.top_section=1;
 app.guix.slide.vars.num_section=1;
 app.guix.slide.vars.data_ray=[];
 app.guix.slide.vars.is_animating=false;
 app.guix.slide.vars.x_limit=0;
 app.guix.slide.vars.width=0;
 app.guix.slide.vars.x_pos=0;
 app.guix.slide.vars.y_pos=0;
 app.guix.slide.vars.y_max=0;
 app.guix.slide.vars.dir=-1;
 app.guix.slide.vars.speed=44;

 guixCreate("canvas","b_kbcanvas_0",9930,guixMsgProc);
 app.guix.widget_keyboard=guixWidgetKeyboardNew("b_kbcanvas_0",888,guixWidgetMsgProc);
 app.guix.widget_ray.push(app.guix.widget_keyboard);

 guixCreate("canvas","b_chatlog_0",9920,guixMsgProc);
 app.guix.widget_chatlog=guixWidgetChatLogNew("b_chatlog_0",888,guixWidgetMsgProc);
 app.guix.widget_ray.push(app.guix.widget_chatlog);

 guixCreate("canvas","b_chatfield_0",9980,guixMsgProc);
 app.guix.widget_chatfield=guixWidgetFieldNew("b_chatfield_0",888,guixWidgetMsgProc);
 app.guix.widget_ray.push(app.guix.widget_chatfield);

 guixCreate("canvas","b_chatpix_0",9980,guixMsgProc);

 guixCreate("video","b_vippy_0",9990,guixMsgProc);



 //alert(app.guix.widget_ray.length);


 guixFontsLoad();
 app.guix.pixels_per_xpc=0;
 app.guix.pixels_per_ypc=0;
 aa.ifaceStart(guixIfaceProc);
 }






/*-----------------------------------------------------------------------*/



 function guixDimensionsGet (obj,what)
 {
 var dwid,dhit,cord,dord,xx,yy,ww,hh,rect,area,brea,crea,drea;

 dwid=obj.this_dsz[0]; dhit=obj.this_dsz[1];
 dwid=obj.this_dsz[5]; dhit=obj.this_dsz[8];
 rect=null;

 if(obj.this_dsz[10]==true)
  {
  }

 if(what=="b_topbar_0")
  {
  rect=aa.guiRectSet(0,0,dwid,50);
  }
 else
 if(what=="b_kbcanvas_0")
  {
  cord=aa.guiGridToCord(0,30,dwid,dhit);
  xx=0;
  yy=dhit-cord.y;
  hh=cord.y;
  ww=(dwid-(xx*2))>>0;
  rect=aa.guiRectSet(xx,yy,ww,hh);
  }
 else
 if(what=="b_chatfield_0")
  {
  //area=guixAreaGet("b_canstream_0");
  cord=aa.guiGridToCord(0,64,dwid,dhit);
  dord=aa.guiGridToCord(0,6,dwid,dhit);
  xx=0;
  yy=cord.y;
  ww=(dwid-(xx*2))>>0;
  hh=Math.floor(dord.y)+1;
  rect=aa.guiRectSet(xx,yy,ww,hh);
  }
 else
 if(what=="b_chatlog_0")
  {
  cord=aa.guiGridToCord(0,6,dwid,dhit);
  area=guixAreaGet("b_canstream_0");
  brea=guixAreaGet("b_chatfield_0");
  crea=guixAreaGet("b_topbar_0");
  xx=0;
  yy=crea.top+crea.height;
  ww=area.left;
  hh=brea.top-yy;
  rect=aa.guiRectSet(xx,yy,ww,hh);
  }


 return rect;
 }



/*-----------------------------------------------------------------------*/



 function guixSidemenuDataReset ()
 {
 app.guix.slide.vars.data_ray=[];
 app.guix.slide.vars.num_section=1;
 }



 function guixSidemenuSectionAppend ()
 {
 guixSidemenuDataAppend({section:app.guix.slide.vars.num_section});
 app.guix.slide.vars.num_section++;
 }




 function guixSidemenuDataAppend (data)
 {
 data.self_index=app.guix.slide.vars.data_ray.length;
 app.guix.slide.vars.data_ray.push(data);
 }


 function guixSidemenuHeadingAppend (data,state)
 {
 guixSidemenuDataAppend({heading:data,open:state});
 }





 function guixSidemenuDataSectionGet (val)
 {
 var i,item;
 for(i=0;i<app.guix.slide.vars.data_ray.length;i++)
  {
  item=app.guix.slide.vars.data_ray[i];
  if(item.section===undefined) { continue; }
  if(item.section!=val)        { continue; }
  return item;
  }
 return null;
 }




 function guixSidemenuHeadingSelect (val)
 {
 var i,item,h;
 if(app.guix.slide.vars.cur_section==val) { app.guix.slide.vars.cur_section=""; }
 else                                     { app.guix.slide.vars.cur_section=val; }

/*
 for(i=0;i<app.guix.slide.vars.data_ray.length;i++)
  {
  item=app.guix.slide.vars.data_ray[i];
  if(item.heading==undefined) { continue; }
  item.open=false;
  app.guix.slide.vars.data_ray[i]=item;
  }

 h=1;
 for(i=0;i<app.guix.slide.vars.data_ray.length;i++)
  {
  item=app.guix.slide.vars.data_ray[i];
  if(item.heading==undefined) { continue; }
  if(h==app.guix.slide.vars.cur_section)
   {
   item.open=true;
   break;
   }

  }
  */


// guixLenseHudLog(app.guix.lense,"cursel="+app.guix.slide.vars.cur_section);
 return true;
 }







 function guixSidemenuBuild ()
 {
 var den,i,str,str;

 if(aa.main_state.stage<200) { return true; }
 den=app.media.active_devenu;

 guixSidemenuDataReset();
 if(app.guix.slide.vars.data_ray.length==0)
  {
  if(den.vid_input_list.length>1)
   {
   guixSidemenuSectionAppend();
   str="Cameras";
   guixSidemenuHeadingAppend(str,(app.guix.slide.vars.cur_section==str));
   for(i=0;i<den.vid_input_list.length;i++)
    {
    str=den.vid_input_list[i].clean;
    guixSidemenuDataAppend({item:str,state:(app.media.cur_vxi==i),isswitch:false});
    }
   }

  if(den.aud_input_list.length>1)
   {
   guixSidemenuSectionAppend();
   str="Mics";
   guixSidemenuHeadingAppend(str,(app.guix.slide.vars.cur_section==str));
   for(i=0;i<den.aud_input_list.length;i++)
    {
    str=den.aud_input_list[i].clean;
    guixSidemenuDataAppend({item:str,state:(app.media.cur_axi==i),isswitch:false});
    }
   }


  if(den.aud_output_list.length>1)
   {
   guixSidemenuSectionAppend();
   str="Speakers";
   guixSidemenuHeadingAppend(str,(app.guix.slide.vars.cur_section==str));
   for(i=0;i<den.aud_output_list.length;i++)
    {
    str=den.aud_output_list[i].clean;
    guixSidemenuDataAppend({item:str,state:(app.media.cur_axo==i),isswitch:false});
    }
   }

  ///console.log("aud act="+app.options.aud_act);
  guixSidemenuSectionAppend();
  str="Options";
  guixSidemenuHeadingAppend(str,(app.guix.slide.vars.cur_section==str));
  guixSidemenuDataAppend({item:'Audio activity',state:app.options.aud_act,isswitch:true});
  guixSidemenuDataAppend({item:'Auto hello',state:app.options.auto_hello,isswitch:true});

  guixSidemenuSectionAppend();
  str="Effects";
  guixSidemenuHeadingAppend(str,(app.guix.slide.vars.cur_section==str));
  guixSidemenuDataAppend({item:'Censor',state:app.options.fx_censor,isswitch:true});
  guixSidemenuDataAppend({item:'Brighten',state:app.options.fx_brighten,isswitch:true});
  guixSidemenuDataAppend({item:'Darken',state:app.options.fx_darken,isswitch:true});
  guixSidemenuDataAppend({item:'Disco',state:app.options.fx_disco,isswitch:true});


//  guixSidemenuSectionAppend();
//  str="Security";
//  guixSidemenuHeadingAppend(str,(app.guix.slide.vars.cur_section==str));
//  guixSidemenuDataAppend({item:'Encryption: ECC-384',state:false,isswitch:false});


  guixSidemenuSectionAppend();
  str="Todo";
  guixSidemenuHeadingAppend(str,(app.guix.slide.vars.cur_section==str));
  guixSidemenuDataAppend({item:'Scrolling chat log',state:true,isswitch:false});
  guixSidemenuDataAppend({item:'Persistant chat log',state:true,isswitch:false});
  guixSidemenuDataAppend({item:'File sharing',state:true,isswitch:false});

  guixSidemenuSectionAppend();
  str="Bugs";
  guixSidemenuHeadingAppend(str,(app.guix.slide.vars.cur_section==str));
  guixSidemenuDataAppend({item:'More than I care for',state:true,isswitch:false});


  guixSidemenuSectionAppend();
  str="About";
  guixSidemenuHeadingAppend(str,(app.guix.slide.vars.cur_section==str));
  guixSidemenuDataAppend({item:'aa_version: '+aa_version,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'cpu_speed: '+app.cpu_speed,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'finger_print: '+app.ei.finger_print,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'is_mobile: '+app.ei.is_mobile,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'is_real_mobile: '+app.ei.is_real_mobile,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'is_standalone: '+app.ei.is_standalone,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'is_touch: '+app.ei.is_touch,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'is_win: '+app.ei.is_win,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'name: '+app.ei.name,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'platform: '+app.ei.platform,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'ver: '+app.ei.ver,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'who: '+app.ei.who,state:true,isswitch:false});

  guixSidemenuDataAppend({item:'app_version: '+cfg_app_version,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'app_speed: '+cfg_app_speed,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'peers_max: '+cfg_peers_max,state:true,isswitch:false});

  guixSidemenuDataAppend({item:'audio_script_proc_size: '+cfg_audio_script_processor_size,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'audio_fft_size: '+cfg_audio_fft_size,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'audio_max_db: '+cfg_audio_max_db,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'audio_min_db: '+cfg_audio_min_db,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'audio_analysis_cycle: '+cfg_audio_analysis_cycle,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'audio_threshold: '+cfg_audio_threshold,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'audio_default_gain: '+cfg_audio_default_gain,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'v_fps: '+cfg_v_fps,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'a_aec: '+cfg_a_aec,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'a_nsu: '+cfg_a_nsu,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'a_agc: '+cfg_a_agc,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'sdp_change_bitrate: '+cfg_sdp_change_bitrate,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'sdp_use_arate: '+cfg_sdp_use_arate,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'sdp_use_vrate: '+cfg_sdp_use_vrate,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'chatpix_width: '+cfg_chatpix_width,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'chatpix_height: '+cfg_chatpix_height,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'cam_res_wid: '+cfg_cam_res_wid,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'cam_res_short: '+cfg_cam_res_short,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'cam_res_rot: '+cfg_cam_res_rot,state:true,isswitch:false});
  guixSidemenuDataAppend({item:'copyright: ope(c)n Ashod Apakian',state:false,isswitch:false});




  guixSidemenuSectionAppend();
  }

 return true;
 }









 function guixSidemenuPaint ()
 {
 var j,k,i,spid,txt,fnt,mes,mesa,mesb,mesc,mesd,grpv,str,grpa;
 var xx,yy,spirect;
 var brea,first;
 var itema,itemb,itemc,itemd,head;

 if((grpa=guixGroupGet("b_animlay_1"))==null)  { aa.debugAlert(); }
 if((grpv=guixGroupGet("b_virtlay_1"))==null)  { aa.debugAlert(); }

 brea=guixAreaGet(grpa.obj.id);

 if(app.guix.slide.vars.data_ray.length>0)
  {
  aa.guiSpotPurge(grpa.han);
  j=1;//app.guix.slide.vars.top_section;//+aa.numRand(2);
  spid=5555;
  xx=10;
  yy=10;
  while(1)
   {
   if((j+1)==app.guix.slide.vars.num_section) { break; }
   itema=guixSidemenuDataSectionGet(j+0);
   itemb=guixSidemenuDataSectionGet(j+1);
   itemc=itemb.self_index-itema.self_index;
   k=0;
   for(i=0;i<itemc;i++)
    {
    itemd=app.guix.slide.vars.data_ray[itema.self_index+i];
    if(itemd.heading!==undefined)
     {
     first=true;
     //yy+=8;
     //aa.guiCanvasSmoothingSet(grpv.han,false);// (handle,state,offx,offy,blur,color)
     aa.guiCanvasSmoothingSet(grpv.han,true,1,1,1,aa.guiRgbaString(1,1,9,1));
     head=itemd.heading;
     txt=itemd.heading;
     fnt=aa.guiFontString(300,34,"spreadtall");
     mesc=aa.guiCanvasFontMeasure(grpv.han,fnt,txt);
     if(itemd.open) { aa.guiCanvasText(grpv.han,20,yy ,0,aa.guiRgbaString(10,10,19,1),aa.guiRgbaString(240,240,240,1),fnt,txt); }
     else           { aa.guiCanvasText(grpv.han,20,yy ,0,aa.guiRgbaString(10,10,19,1),aa.guiRgbaString(255,255,255,1),fnt,txt); }
     if(itemd.open) { txt=aa.guiUni("u25b2"); }
     else           { txt=aa.guiUni("u25bc"); }
     mesa=aa.guiCanvasFontMeasure(grpv.han,fnt,txt);
     if(itemd.open) { aa.guiCanvasText(grpv.han,brea.width-mesa.aw-20,yy ,0,aa.guiRgbaString(20,210,29,1),aa.guiRgbaString(240,240,240,1),fnt,txt); }
     else           { aa.guiCanvasText(grpv.han,brea.width-mesa.aw-20,yy ,0,aa.guiRgbaString(20,210,29,1),aa.guiRgbaString(200,200,240,1),fnt,txt); }
     aa.guiCanvasLine(grpv.han,20,yy+mesc.ah+8,20+brea.width-40,yy+mesc.ah+8,2,aa.guiRgbaStringCommon(4,0.8));
     //aa.guiSpotAdd(grpa.han,spid,20,yy,brea.width-40,mesc.ah+4,"head",j,0);
     aa.guiSpotAdd(grpa.han,spid,brea.width-mesa.aw-16,yy,mesa.aw,mesc.ah+4,"head",head,0);
     //aa.guiSpotAdd(grpa.han,spid,brea.width-40,yy,mesa.aw,mesc.ah+4,"head",head,0);
     spid++;
     yy+=mesa.height+8;
     if(itemd.open==false) { break; }
     continue;
     }
    if(itemd.item!==undefined)
     {
     if(first==true) {  yy+=8;  } else { yy+=4; }
     //aa.guiCanvasSmoothingSet(grpv.han,false);// (handle,state,offx,offy,blur,color)
     aa.guiCanvasSmoothingSet(grpv.han,true,1,1,1,aa.guiRgbaString(1,1,9,1));
     fnt=aa.guiFontString(300,18,"saira");
     mesb=aa.guiCanvasFontMeasure(grpv.han,fnt,"|");
     str=itemd.item;
     mesd=aa.guiCanvasFontMeasure(grpv.han,fnt,str);
     if(itemd.state) { aa.guiCanvasText(grpv.han,20,yy ,0,aa.guiRgbaString(20,10,329,1),aa.guiRgbaString(210,255,145,1),fnt,str); }
     else            { aa.guiCanvasText(grpv.han,20,yy ,0,aa.guiRgbaString(20,10,329,1),aa.guiRgbaString(230,200,200,1),fnt,str); }
     if(itemd.isswitch==true)
      {
      if(itemd.state) { spirect=aa.spriteRectGet(app.sprite,351); }
      else            { spirect=aa.spriteRectGet(app.sprite,354); }
      if(spirect!=null)
       {
       aa.spritePaint(app.sprite,"b_virtlay_1",spirect.x,spirect.y,spirect.w,spirect.h, 20+(brea.width/2),yy+0, (mesc.fh-8)*spirect.ratio_wh,(mesc.fh-8), 0,0,0);
       }
      aa.guiSpotAdd(grpa.han,spid,20+(brea.width/2),yy+0, (mesc.fh-8)*spirect.ratio_wh,(mesc.fh-10),"item",j,k);
      }
     else
      {
      aa.guiSpotAdd(grpa.han,spid,20,yy+0,mesd.aw,mesd.ah+2,"item",head,k);
      }
     k++;
     spid++;
     yy+=mesd.ah+6;
     if(first==true) { yy+=4; first=false; }
     continue;
     }
    }
   yy+=(mesa.height>>2);
   app.guix.slide.vars.y_max=yy;
   j++;
   }
  }
 app.guix.slide.vars.y_max-=100;
 ///console.log("y_max="+app.guix.slide.vars.y_max);
 aa.guiCanvasSmoothingSet(grpv.han,false);
 return true;
 }




/*-----------------------------------------------------------------------*/



 function guixLensePaintProc (obj)
 {
 var lobj0,lobj1,fs,fnt,xx,yy,ww,hh,i,txt;
 lobj0=obj.layer[0];
 lobj1=obj.layer[1];
 if(obj.id=="hudlay")
  {
  //console.log(obj.id);
  aa.guiLenseClear(obj,0);
  fs=lobj1.area.height/20;
  fnt=aa.guiFontString(600,fs,"srccodepro");
  xx=yy=i=0;
  while(1)
   {
   if(i>=app.guix.lense.vars.rows) { break; }
   if(yy>=lobj0.area.height) { break; }
   txt=app.guix.lense.vars.line[i];
   aa.guiCanvasText(lobj0.grp.han,xx,yy,1,aa.guiRgbaStringCommon(1,1),aa.guiRgbaStringCommon(0,1),fnt,txt);
   yy+=fs;
   i++;
   }
  //aa.guiCanvasFillFull(lobj0.grp.han,aa.guiRgbaStringCommon(aa.numRand(10),1.0));
  return true;
  }
 if(aa.main_state.stage<200) { return true; }
 if(obj.id=="slidelay")
  {
  ///console.log(obj.id);
  ww=lobj1.area.width;
  //console.log(ww);
  hh=lobj1.area.height;
  aa.guiLenseClear(obj,0);
  grad=lobj0.grp.obj.ctx.createLinearGradient(0,0,ww,hh);
  if(0)
   {
   grad.addColorStop(0.0,aa.guiRgbaString(5,121,221,1.0));
   grad.addColorStop(0.5,aa.guiRgbaString(45,15,225,1.0));
   grad.addColorStop(1.0,aa.guiRgbaString(5,225,255,1.0));
   }
  else
   {
   grad.addColorStop(0.0,aa.guiRgbaString(121,121,221,1.0));
   grad.addColorStop(0.5,aa.guiRgbaString(145,145,225,1.0));
   grad.addColorStop(1.0,aa.guiRgbaString(125,125,125,1.0));
   }

  aa.guiCanvasFill(lobj0.grp.han,0,0,ww,lobj0.area.height,grad);
  //aa.guiCanvasBorder(lobj0.grp.han,0,0,ww,hh,3,aa.guiRgbaStringCommon(0,1.0));
  guixSidemenuBuild();
  guixSidemenuPaint();
  return true;
  }
 }



 function guixLenseHudLog (obj,txt)
 {
 var i,lines;
 //return;
 lines=app.guix.lense.vars.rows;
 for(i=0;i<lines-1;i++)
  {
  app.guix.lense.vars.line[i+0]=app.guix.lense.vars.line[i+1];
  }
 app.guix.lense.vars.line[(lines)-1]=txt;
 aa.guiLenseNeedsPaintSet(obj,true);
// console.log(txt);
// guixLenseNeedsPaintSet(obj,true);
 return true;
 }




/*-----------------------------------------------------------------------*/



 function guixFontsLoad ()
 {
 var s;
 s=Math.floor(Date.now()/10000);
 app.guix.font_ray.push(aa.guiFontLoad("saira","woff","/fonts/saira.woff?"+s));
 app.guix.font_ray.push(aa.guiFontLoad("spreadtall","woff","/fonts/spreadtall.woff?"+s));
 app.guix.font_ray.push(aa.guiFontLoad("srccodepro","woff","/fonts/srccodepro.woff?"+s));
 }




 function guixFontsLoadYield ()
 {
 var c,f;
 if(app.guix.fonts_ready==true) { return; }
 for(c=0,f=0;f<app.guix.font_ray.length;f++)
  {
  if(aa.guiFontStatus(app.guix.font_ray[f])==true) { c++; }
  }
 if(c!=app.guix.font_ray.length) { return; }
 console.log(c+" fonts ready");
 app.guix.fonts_ready=true;
 }




 function guixPixelsPerPcUpdate ()
 {
 var dwid,dhit,cord;
 dwid=document.documentElement.clientWidth;
 dhit=document.documentElement.clientHeight;
 cord=aa.guiGridToCord(1,1,dwid,dhit);
 app.guix.pixels_per_xpc=cord.x;
 app.guix.pixels_per_ypc=cord.y;
 }




 function guixYield (obj)
 {
 var dsz;
 if(arguments.callee.caller.name!="guixIfaceProc") { return; }
 guixFontsLoadYield();
 dsz=obj.this_dsz;
 //dhit=obj.this_dsz[8];
 ///dsz=aa.ifaceDisplaySizesGet();

  ///guixLenseHudLog(app.guix.lense,"amfp "+dsz[5]+" "+dsz[8]);//aa.main_state.cycle);
 mediaCanvasPaint(dsz);
 }




 function guixCreate (type,id,zi,msgproc)
 {
 var han,grp,pixels;
 if((han=aa.guiCreate(type,id,zi))==0)  { aa.debugAlert(); }
 if((grp=aa.guiGroupGetById(id))==null) { aa.debugAlert(); }
 grp.vars.needs_paint=true;
 grp.vars.msgproc=msgproc;
 grp.vars.expect={};
 grp.vars.expect.disp="none";
 grp.vars.expect.retina=false;
 grp.vars.expect.opacity=1.0;
 grp.vars.expect.rect=aa.guiRectSet(10,10,20,20);
 grp.vars.expect.dow=null;
 grp.vars.expect.doh=null;
 while(1)
  {
  pixels=1;
  if(1&&type=="canstream") {  aa.guiCssOutlineSet(grp.han,pixels,0,4,aa.guiRgbaStringCommon(16,1));   break;   }
  if(1&&type=="video")     {  aa.guiCssOutlineSet(grp.han,pixels,0,4,aa.guiRgbaStringCommon(16,1));   break;   }
  if(0&&type=="canvas")    {  aa.guiCssOutlineSet(grp.han,pixels,-(pixels*1),4,aa.guiRgbaStringCommon((8+grp.obj.guc)%9,1));   break;   }
  break;
  }
 grp.dom.style.touchAction="none";
 grp.dom.style.pointerEvents="none";
 app.guix.group_ray.push(grp);
 return grp;
 }





 function guixAreaGet (id)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_guix_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var grp,area;
 grp=guixGroupGet(id);
 if(grp==null) { aa.debugAlert(); }
 area=aa.guiCssAreaGet(grp.han);
 return area;
 }




 function guixNeedsPaintSet (id)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_guix_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var e,grp,done;
 done=0;
 for(e=0;e<app.guix.group_ray.length;e++)
  {
  grp=app.guix.group_ray[e];
  if(id!=null)   { if(grp.obj.id!=id) { continue; }   }
  grp.vars.needs_paint=true;
  done++;
  if(id!=null)   { break; }
  }
 }



 function guixMsgProc (grp,mesg)
 {
 var reply;
 ///console.log("msgproc= "+grp.obj.id+"  "+mesg.cmd);

 if(grp.obj.id=="b_chatlog_0")
  {
  guixWidgetChatLogPaint(app.guix.widget_chatlog);
  reply={};
  reply.result="ok";
  reply.cmd=mesg.cmd;
  reply.grp=grp;
  ///guixNeedsPaintSet(grp.obj.id);
  grp.vars.needs_paint=false;
  return reply;
  }

 if(grp.obj.id=="b_chatfield_0")
  {
  guixWidgetFieldPaint(app.guix.widget_chatfield);
  reply={};
  reply.result="ok";
  reply.cmd=mesg.cmd;
  reply.grp=grp;
  //guixNeedsPaintSet(grp.obj.id);
  grp.vars.needs_paint=false;
  return reply;
  }

 if(grp.obj.id=="b_topbar_0")
  {
  guixTopbarPaint(grp);
  reply={};
  reply.result="ok";
  reply.cmd=mesg.cmd;
  reply.grp=grp;
//  guixNeedsPaintSet(grp.obj.id);
  grp.vars.needs_paint=false;
  return reply;
  }
 if(grp.obj.id=="b_kbcanvas_0")
  {
  //console.log("xxx "+mesg.cmd);
  guixWidgetKeyboardPaint(app.guix.widget_keyboard);
  reply={};
  reply.result="ok";
  reply.cmd=mesg.cmd;
  reply.grp=grp;
  //guixNeedsPaintSet(grp.obj.id);
  grp.vars.needs_paint=false;
  return reply;
  }



 reply={};
 reply.result="ok";
 reply.cmd=mesg.cmd;
 reply.grp=grp;
 return reply;
 }






 function guixTopbarPaint (grp)
 {
 var grad,dwid,dhit,area,ret,spc,www,hhh,mes,fnt,txt,spx;

 aa.guiSpotPurge(grp.han);
 area=aa.guiCssAreaGet(grp.han);
 //console.log(grp.obj.id);
 dwid=area.width;
 dhit=area.height;
 //console.log(dwid+" "+dhit+"  "+grp.dom.width+"  "+grp.dom.height);
 grad=grp.obj.ctx.createLinearGradient(dwid/4,0,dwid,dhit);
// grad.addColorStop(0.0,aa.guiRgbaString(45,220,184,1.0));
 grad.addColorStop(0.0,aa.guiRgbaString(23,43,77,1.0));
 grad.addColorStop(0.5,aa.guiRgbaString(20,100,130,1.0));
 grad.addColorStop(1.0,aa.guiRgbaString(9,30,66,1.0));

 //grad.addColorStop(1.0,aa.guiRgbaString(45,220,234,1.0));
 aa.guiCanvasFillFull(grp.han,grad);
 aa.guiCanvasBorder(grp.han,0,0,dwid,dhit,1,aa.guiRgbaStringCommon(0,1));

 if(app.sprite==undefined)     { return; }
 if(app.sprite.is_ready!=true) { return; }

 spx=304;
 spc=aa.spriteRectGet(app.sprite,spx);
 hhh=(dhit-10);
 www=hhh*spc.ratio_wh;
 aa.spritePaintByIndex(app.sprite,"b_topbar_0",spx,5,5,www,hhh,0,0,0);
 aa.guiSpotAdd(grp.han,1000,5,5,www,hhh,"ashod",1,0);

 spx=263;
 spc=aa.spriteRectGet(app.sprite,spx);
 hhh=(dhit-10);
 www=hhh*spc.ratio_wh;
 if(app.guix.slide.vars.width<15)  {  aa.spritePaintByIndex(app.sprite,"b_topbar_0",spx,dwid-www-5,5,www,hhh,0,3,0);  }
 else                              {  aa.spritePaintByIndex(app.sprite,"b_topbar_0",spx,dwid-www-5,5,www,hhh,0,0,0);  }
 aa.guiSpotAdd(grp.han,1001,dwid-www-5,5,www,hhh,"options",1,0);

 spx=296;
 spc=aa.spriteRectGet(app.sprite,spx);
 hhh=(dhit-20);
 www=hhh*spc.ratio_wh;
 aa.spritePaintByIndex(app.sprite,"b_topbar_0",spx,dwid-(www*2)-25,10,www,hhh,0,0,0);
 aa.guiSpotAdd(grp.han,1002,dwid-(www*2)-25,10,www,hhh,"share",1,0);

 spx=266;
 spc=aa.spriteRectGet(app.sprite,spx);
 hhh=(dhit-18);
 www=hhh*spc.ratio_wh;
 if(app.media.is_mute==true)
  {
  aa.spritePaintByIndex(app.sprite,"b_topbar_0",spx,dwid-(www*4)-40,10,www,hhh,0,0,aa.guiRgbaStringCommon(2,0.8));
  }
 else
  {
  aa.spritePaintByIndex(app.sprite,"b_topbar_0",spx,dwid-(www*4)-40,10,www,hhh,0,0,0);
  }
 aa.guiSpotAdd(grp.han,1003,dwid-(www*4)-44,8,www+8,hhh+4,"mute",1,0);


 if(app.beam!==undefined&&app.beam.sh1!==undefined&&app.beam.sh1.room)
  {
  fnt=aa.guiFontString(600,dhit*0.40,"arial");
  if(app.in_call==true)
   {
   txt=app.beam.sh1.room;
   }
  else
   {
   txt="";
   }
  mes=aa.guiCanvasFontMeasure(grp.han,fnt,txt);
//  aa.guiCanvasText(grp.han,(dwid/2)-(mes.aw/2),(dhit-mes.ah)/2,3,aa.guiRgbaString(20,10,29,0.8),aa.guiRgbaStringCommon(1,1),fnt,txt);
  aa.guiCanvasText(grp.han,60,(dhit-mes.ah)/2,3,aa.guiRgbaString(20,10,29,0.8),aa.guiRgbaStringCommon(1,1),fnt,txt);
  }

 }






 function guixPeersPaint (obj)
 {
 var dwid,dhit,rat,n,rect,rexa,rexb,hit,xxx,yyy,www,hhh,id;

 dwid=obj.this_dsz[5];
 dhit=obj.this_dsz[8];
  rat=(obj.this_dsz[5]/obj.this_dsz[8]);
 rexa=guixDimensionsGet(obj,"b_topbar_0");
 rexb=guixDimensionsGet(obj,"b_chatfield_0");//kbcanvas_0");
  hit=rexb.y-(rexa.y+rexa.h)
  ///guixLenseHudLog(app.guix.lense,"bmfp "+rat);//state.cycle+" "+vgrp.dom.videoWidth+"  "+vgrp.dom.videoHeight);
 if(rat>1.37)
  {
  hhh=hit/2;
  www=hhh*1.33;
  //www=hhh*0.75;
  xxx=dwid-((www*2)+0);
  app.guix.slide.vars.x_limit=xxx;

  yyy=rexa.y+rexa.h;
  rect=aa.guiRectSet(xxx,yyy,www,hhh);
  //guixExpect("b_chatlog_0",1,0,1.0,null,null,true,0,yyy,dwid-(www*2)-4,rex.h-yyy);
  for(n=0;n<cfg_peers_max;n++)
   {
   if(n==0)
    {
    id="b_canstream_"+n;
    grp=guixGroupGet(id);
    guixExpect(id,1,0,1.0,320,240,true,rect.x,rect.y,rect.w,rect.h);
    }
   else
    {
    id="b_video_"+n;
    grp=guixGroupGet(id);
    guixExpect(id,1,0,1.0,320,240,true,rect.x,rect.y,rect.w,rect.h);
    }
   rect.x+=rect.w;
   if((n%2)==1)
    {
    rect.x-=rect.w*2;
    rect.y+=rect.h;
    }
   }
  }
 else
  {
  hhh=hit/4;
  www=hhh*1.33;
  www-=20;
  //www=hhh;
  xxx=dwid-((www*1)+0);
  //xxx=
  app.guix.slide.vars.x_limit=xxx;
  //app.guix.slide.vars.x_limit=240;
   //guixLenseHudLog(app.guix.lense,"xlim="+app.guix.slide.vars.x_limit);
  yyy=rexa.y+rexa.h;
  rect=aa.guiRectSet(xxx,yyy,www,hhh);
  //guixLenseHudLog(app.guix.lense,www+"  "+hhh);//lide.vars.x_limit);
  for(n=0;n<cfg_peers_max;n++)
   {
   if(n==0)
    {
    id="b_canstream_"+n;
    grp=guixGroupGet(id);
    guixExpect(id,1,0,1.0,320,240,true,rect.x,rect.y,rect.w,rect.h);
    }
   else
    {
    id="b_video_"+n;
    grp=guixGroupGet(id);
    guixExpect(id,1,0,1.0,320,240,true,rect.x,rect.y,rect.w,rect.h);
    }
   rect.y+=rect.h;
   }
  }
 }



//function guixExpect (id,disp,retina,opacity,dow,doh,dorect,rx,ry,rw,rh)


//var isif=0;

 function guixIfaceProc (obj)
 {
 var n,grp,chg,msg,reply,rect,col,cols,across,dwid,dhit,down,row,bc,lay0,lay1,i,spt,g,rex,rat,lobj,cord;

 ///if(aa.main_state.stage<200) { return; }
//if(isif==0) { isif=1; console.log("isif"); }

 dwid=obj.this_dsz[5];
 dhit=obj.this_dsz[8];

 //ptrYield();

 guixPixelsPerPcUpdate();
 guixWidgetFieldCaretHandler(app.guix.widget_chatfield);

 guixPeersPaint(obj);


 if(obj.is_disp_change==true)
  {
  aa.guiLenseNeedsPaintSet(app.guix.lense,true);
  aa.guiLenseNeedsPaintSet(app.guix.slide,true);
  //guixLenseNeedsPaintSet(app.guix.lense,true);
  if(app.guix.slide.vars.width>20&&app.guix.slide.vars.is_animating==false)
   {
   app.guix.slide.vars.is_animating=true;
   }
  }



 rex=guixDimensionsGet(obj,"b_topbar_0");   guixExpect("b_topbar_0",1,0,1.0,null,null,true,rex.x,rex.y,rex.w,rex.h);
 rex=guixDimensionsGet(obj,"b_kbcanvas_0"); guixExpect("b_kbcanvas_0",1,0,1.0,null,null,true,rex.x,rex.y,rex.w,rex.h);
 rex=guixDimensionsGet(obj,"b_chatfield_0");  guixExpect("b_chatfield_0",1,0,1.0,null,null,true,rex.x,rex.y,rex.w,rex.h);

 lobj=app.guix.lense.layer[0]; guixExpect(lobj.id,0,0,0.0,null,null,true,0,0,dwid*1,dhit*2);
 lobj=app.guix.lense.layer[1]; guixExpect(lobj.id,1,0,0.9,null,null,true,0,0,dwid*1,dhit*1);

 cord=aa.guiGridToCord(0,30,dwid,dhit);
 //rex=guixDimensionsGet(obj,"b_chatlog_0");
 lobj=app.guix.slide.layer[0]; guixExpect(lobj.id,0,0,0.0,null,null,true,0,0,dwid*2,dhit*4);
 lobj=app.guix.slide.layer[1]; guixExpect(lobj.id,1,0,0.9,null,null,true,0,50,app.guix.slide.vars.width,dhit-cord.y-50-20);
 //rex.w,dhit-250);//rex.h);//dhit-100);//(dhit*1)-100-65);

  //guixExpect("b_vippy_0",1,0,1.0,null,null,true,200,200,320,240);



 guixExpect("b_chatpix_0",0,0,1.0,null,null,true,0,0,cfg_chatpix_width*10,cfg_chatpix_height*10);

 rex=guixDimensionsGet(obj,"b_chatlog_0");
 guixExpect("b_chatlog_0",1,0,1.0,null,null,true,rex.x,rex.y,rex.w,rex.h);


 if(app.guix.slide.vars.is_animating==true)
  {
  //ixLenseHudLog(app.guix.lense,"is animating "+app.guix.slide.vars.dir);
  //console.log(app.guix.slide.vars.width);
  if(app.guix.slide.vars.dir>=0)
   {
   if(app.guix.slide.vars.width<app.guix.slide.vars.x_limit)
    {
    if(aa.main_state.cycle>=50) {  app.guix.slide.vars.width+=app.guix.slide.vars.speed;     }
    }
   if(app.guix.slide.vars.width>=app.guix.slide.vars.x_limit)
    {
    app.guix.slide.vars.width=app.guix.slide.vars.x_limit;
    }
   if(app.guix.slide.vars.width==app.guix.slide.vars.x_limit)
    {
    app.guix.slide.vars.is_animating=false;
    guixTopbarPaint(guixGroupGet("b_topbar_0"));
    }
    //guixLenseHudLog(app.guix.lense,"sp="+app.guix.slide.vars.speed+" wi="+app.guix.slide.vars.width+"  "+app.guix.slide.vars.x_limit);
   }
  else
   {
   if(app.guix.slide.vars.width>0)
    {
    if(aa.main_state.cycle>=50) {  app.guix.slide.vars.width-=app.guix.slide.vars.speed;     }
    }
   if(app.guix.slide.vars.width<0)
    {
    app.guix.slide.vars.width=0;
    guixTopbarPaint(guixGroupGet("b_topbar_0"));
    }
   if(app.guix.slide.vars.width==0)
    {
    app.guix.slide.vars.is_animating=false;
    guixTopbarPaint(guixGroupGet("b_topbar_0"));
    }
   //guixLenseHudLog(app.guix.lense,"sp="+app.guix.slide.vars.speed+" wi="+app.guix.slide.vars.width);
   }
  }
 else
  {
  if(app.guix.slide.vars.width>=app.guix.slide.vars.x_limit)
   {
   //app.guix.slide.vars.width=app.guix.slide.vars.x_limit;
   }
  else
   {
   //if(app.guix.slide.vars.width>2)    {    app.guix.slide.vars.width=app.guix.slide.vars.x_limit;    }
   }
  }



 //guixLenseHudLog(app.guix.lense,"sp="+app.guix.slide.vars.speed+" wi="+app.guix.slide.vars.width+"  "+app.guix.slide.vars.is_animating);


///unction guixLenseHudLog (obj,txt)

 for(n=0;n<app.guix.group_ray.length;n++)
  {
  grp=app.guix.group_ray[n];
  chg=guixApply(grp.obj.id,obj.this_dsz,grp.vars.expect);
  if(chg!=0)                     { grp.vars.needs_paint=true;   }
  if(grp.vars.needs_paint!=true) { continue; }
  if(grp.css.display=="none")    { grp.vars.needs_paint=false; continue; }
  if(1)
   {
   msg={};
   msg.cmd="paint";
   reply=grp.vars.msgproc(grp,msg);
   msg=null;
   reply=null;
   }
  grp.vars.needs_paint=false;
  }

 guixYield(obj);



 if(app.guix.lense.needs_paint==true)
  {
  aa.guiLenseAreaCalc(app.guix.lense);
  lay0=app.guix.lense.layer[0];
  lay1=app.guix.lense.layer[1];
  aa.guiLenseNeedsPaintSet(app.guix.lense,true);
  aa.guiLensePaint(app.guix.lense);
  aa.guiLenseRectSet(app.guix.lense,0,0,0, lay1.area.width, lay1.area.height);
  aa.guiLenseRectSet(app.guix.lense,1,0,0, lay1.area.width, lay1.area.height);
  aa.guiLenseProject(app.guix.lense);
  }

 //if(app.guix.slide.needs_paint==true)
 //if(app.guix.slide.needs_paint==true)
 //if(app.guix.slide.vars.is_animating==true)
 if(app.guix.slide.vars.width>1||app.guix.slide.needs_paint==true)
  {
  aa.guiLenseAreaCalc(app.guix.slide);
  lay0=app.guix.slide.layer[0];
  lay1=app.guix.slide.layer[1];
  if(lay1.area.width>1&&lay1.area.height>1)
   {
  aa.guiLenseNeedsPaintSet(app.guix.slide,true);
  aa.guiLensePaint(app.guix.slide);
  aa.guiLenseRectSet(app.guix.slide,0,0,app.guix.slide.vars.y_pos, lay1.area.width, lay1.area.height);
  //aa.guiLenseRectSet(app.guix.slide,0,0,0, lay1.area.width, lay1.area.height);
  aa.guiLenseRectSet(app.guix.slide,1,0,0, lay1.area.width, lay1.area.height);
  aa.guiLenseProject(app.guix.slide);
   }
  }


 if(cfg_spot_show==true)
  {
  guixShowSpots();
  }

// aa.guiCanvasFillFull(guixGroupGet("b_kbcanvas_0").han,aa.guiRgbaStringCommon(5,1));

///ptrYield();
 }








 function guixShowSpots ()
 {
 var g,grp,i,spt;
 for(g=0;g<app.guix.group_ray.length;g++)
  {
  grp=app.guix.group_ray[g];
  if(grp.obj.id=="b_animlay_1")
   {
   for(i=0;i<grp.vars.spot.count;i++)
    {
    spt=grp.vars.spot.ray[i];
    aa.guiCanvasBorder(grp.han,spt.x,spt.y-app.guix.slide.vars.y_pos,spt.w,spt.h,2,aa.guiRgbaStringCommon(8,1));
    }
   }
  else
   {
   for(i=0;i<grp.vars.spot.count;i++)
    {
    spt=grp.vars.spot.ray[i];
    aa.guiCanvasBorder(grp.han,spt.x,spt.y,spt.w,spt.h,2,aa.guiRgbaStringCommon(8,1));
    }
   }
  }
 }








 function guixGroupGet (id)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_guix_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var g,grp;
 for(g=0;g<app.guix.group_ray.length;g++)
  {
  grp=app.guix.group_ray[g];
  if(grp.obj.id==id) { return grp; }
  }
 return null;
 }






 function guixExpect (id,disp,retina,opacity,dow,doh,dorect,rx,ry,rw,rh)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_guix_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var grp,rect;
 if((grp=guixGroupGet(id))==null) { aa.debugAlert("in expect, grp is null, for id "+id); }
 rect=null;
 if(dorect==true)  {  rect=aa.guiRectSet((rx>>0),(ry>>0),(rw>>0),(rh>>0));  }
 if(disp!=null)
  {
  if(disp==1||disp==true)  {  grp.vars.expect.disp="inline-block"; }
  else
  if(disp==0||disp==false) {  grp.vars.expect.disp="none"; }
  else                     {  grp.vars.expect.disp=disp; }
  }
 if(retina!=null)
  {
  if(retina==1||retina==true)  {  grp.vars.expect.retina=true; }
  else
  if(retina==0||retina==false) {  grp.vars.expect.retina=false; }
  else                         {  grp.vars.expect.retina=retina; }
  }
 if(opacity!=null)  {  grp.vars.expect.opacity=opacity; }
 if(rect!=null)     {  grp.vars.expect.rect=rect; }
 grp.vars.expect.dow=dow;
 grp.vars.expect.doh=doh;
 return grp;
 }






 function guixApply (id,dsz,exp)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_guix_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var grp,chg,area,isnanxy,isnanwh,exp,pixels;
 if((grp=guixGroupGet(id))==null) { aa.debugAlert("in apply, grp is null, for id "+id); }
 exp=grp.vars.expect;
 chg=0;
 if(grp.css.display!=exp.disp)    {  grp.css.display=exp.disp;  chg+=1;  }
 if(grp.css.opacity!=exp.opacity) {  grp.css.opacity=exp.opacity;  chg+=2;  }
 area=aa.guiCssAreaGet(grp.han);
 isnanxy=false;
 isnanwh=false;
 if(isNaN(area.left)||isNaN(area.top))     { isnanxy=true; }
 if(isNaN(area.width)||isNaN(area.height)) { isnanwh=true; }
 if(grp.vars.is_retina!=exp.retina)  {  chg+=4;  }
 if(isnanxy==true||((area.left!=exp.rect.left)||(area.top!=exp.rect.top)))  {  chg+=8;  }
 if(isnanwh==true||((area.width!=exp.rect.width)||(area.height!=exp.rect.height)))  {  chg+=16;  }
 if((grp.vars.is_retina!=exp.retina)||((area.left!=exp.rect.x)||(area.top!=exp.rect.y)||(area.width!=exp.rect.w)||(area.height!=exp.rect.h)))
  {
  //aa.guiRetinaSet(grp.han,exp.rect.x,exp.rect.y,exp.rect.w,exp.rect.h,exp.dow,exp.doh,exp.retina);
//  console.log(id+"  "+exp.rect.w+"  "+exp.dow);
  aa.guiRetinaSet(grp.han,exp.rect.x,exp.rect.y,exp.rect.w,exp.rect.h,exp.dow,exp.doh,exp.retina);

  }
 return chg;
 }






//-----------------------------------------------------------------------



 function guixWidgetMsgProc (obj,mesg)
 {
 var txt,grp,key,kms,reply,cmd,myid;
 grp=obj.grp;

 //console.log(obj);
 //console.log(mesg);
 /*
 myid=0;
 if(app.beam!==undefined&&app.beam.sh1!==undefined)
  {
  myid=app.beam.sh1.my_id;
  }
 */

 if(mesg.cmd=="spothit")
  {
  if(mesg.spos.uv2==4)
   {
   if(obj.cat=="keyboard")
    {
    obj.vars.needs_update=true;
    grp.vars.needs_paint=true;
    obj.vars.cur_keyboard++;
    obj.vars.cur_keyboard%=4;
    reply={};
    reply.result="ok";
    reply.cmd=mesg.cmd;
    reply.grp=grp;
    return reply;
    }
   }
  }


 if(mesg.cmd=="spothit")
  {
  if(mesg.spos.uv1=="GO")
   {
   cmd=app.guix.widget_chatfield.vars.txt;
   if(app.beam.sh1!==undefined)
    {
    beamWrite(app.beam.sh1,"shout","aakak",null,"announce",true,cmd);
    app.beam.sh1.ive_said_something=true;
    //beamobj.ive_said_something
    }
   app.guix.widget_chatfield.vars.txt="";
   app.guix.widget_chatfield.vars.txt_start=0;
   app.guix.widget_chatfield.vars.caret_pos=0;
   reply={};
   reply.result="ok";
   reply.cmd=mesg.cmd;
   reply.grp=grp;
   return reply;
   }
  kms=aa.keyboardMessageSet("keydown",mesg.spos.uv1,0,0,0,0);
  guixWidgetFieldEmulateKey(app.guix.widget_chatfield,kms);
  reply={};
  reply.result="ok";
  reply.cmd=mesg.cmd;
  reply.grp=grp;
  return reply;
  }
 reply={};
 reply.result="err";
 reply.cmd=mesg.cmd;
 reply.grp=grp;
 return reply;

 }





/*-----------------------------------------------------------------------*/



 function guixWidgetKeyboardNew (canvasid,uid,msgproc)
 {
 var obj,what,chs,grp;
 grp=guixGroupGet(canvasid);
 if((obj=aa.guiWidgetNew("keyboard",grp.obj.id,uid,msgproc))==null) { aa.debugAlert("widget new keyboard failed");  return null;  }
 obj.vars.cur_keyboard=0;
 obj.vars.rgba_bg=aa.guiRgbaString(0x78,0x78,0x78,1.0);
 obj.vars.rgba_key_bg=aa.guiRgbaString(0x9f,0x9f,0x9f,1.0);
 obj.vars.rgba_key_fg=aa.guiRgbaString(0xff,0xff,0xff,1.0);
 obj.vars.rgba_key_border=aa.guiRgbaString(0x10,10,20,1.0);
 obj.vars.rgba_smooth=aa.guiRgbaString(0x0f,0x09,0x0a,1.0);
 obj.vars.rect=aa.guiRectSet(10,10,20,20);
 obj.vars.is_focused=true;
 obj.vars.needs_update=true;
 obj.vars.key_rounded_radius=4;
 return obj;
 }




 function guixWidgetKeyboardPaint (obj)
 {
 var grp,area,what,chs,i,rec,fs;
 var aw,ah,srec,spt;
 var xgc,ygc,gx,gy,gw,gh,fad;

 if(obj==undefined)      { return; }
 if(obj.type!="widget")  { return; }
 if(obj.cat!="keyboard") { return; }
 grp=obj.grp;
 area=aa.guiCssAreaGet(grp.han);
 what=obj.vars.cur_keyboard;
 chs=[];
 aa.guiSpotPurge(grp.han);

 switch(what)
  {
  case 0:  chs.push("q","w","e","r","t","y","u","i","o","p");  break;
  case 1:  chs.push("Q","W","E","R","T","Y","U","I","O","P");  break;
  case 2:  chs.push("1","2","3","4","5","6","7","8","9","0");  break;
  case 3:  chs.push("[","]","{","}","#","%","^","*","+","=");  break;
  }
 switch(what)
  {
  case 0:  chs.push("a","s","d","f","g","h","j","k","l");  break;
  case 1:  chs.push("A","S","D","F","G","H","J","K","L");  break;
  case 2:  chs.push("-","/",":",";","(",")","$","&","@");  break;
  case 3:  chs.push("_","\\","|","-","<",">",aa.guiUni("u20ac"),aa.guiUni("u00a3"),aa.guiUni("u04b0"));  break;
  }
 switch(what)
  {
  case 0:  chs.push("z","x","c","v","b","n","m");  break;
  case 1:  chs.push("Z","X","C","V","B","N","M");  break;
  case 2:  chs.push("+",",","?",".","'","\"","`");  break;
  case 3:  chs.push(".","?","!",":","/","(",")");  break;
  }
 aa.guiCanvasFillFull(grp.han,obj.vars.rgba_bg);

 ///aa.guiCanvasFillFull(grp.han,aa.guiRgbaStringCommon(aa.numRand(14),0.8));

 xgc=100;
 ygc=100;

 aw=area.width;
 ah=area.height*0.8;//*0.80;  //waypoint, what fraction of the virtual keyboard  height, is dedicated to actual keyboard (from top. down)

 fad=4;

 gx=1; gy=5; gw=8; gh=22;
 for(i=0;i<10;i++)
  {
  rec=guixWidgetKeyRectGet(obj,aw,ah,xgc,ygc,gx,gy,gw,gh,3,3);
  fs=(rec.h/2)+fad;
  guixWidgetKeyPaint(obj,rec.x,rec.y,rec.w,rec.h,fs,1000+(what*100)+i,chs[i],1);
  gx+=10;
  }

 gx=6; gy=30; gw=8; gh=22;
 for(i=10;i<19;i++)
  {
  rec=guixWidgetKeyRectGet(obj,aw,ah,xgc,ygc, gx,gy,gw,gh,3,3);
  fs=(rec.h/2)+fad;
  guixWidgetKeyPaint(obj,rec.x,rec.y,rec.w,rec.h,fs,1000+(what*100)+i,chs[i],1);
  gx+=10;
  }

 gx=16; gy=55; gw=8; gh=22;
 for(i=19;i<26;i++)
  {
  rec=guixWidgetKeyRectGet(obj,aw,ah,xgc,ygc,gx,gy,gw,gh,3,3);
  fs=(rec.h/2)+fad;
  guixWidgetKeyPaint(obj,rec.x,rec.y,rec.w,rec.h,fs,1000+(what*100)+i,chs[i],1);
  gx+=10;
  }


 gx=1; gy=55; gw=12; gh=22;
 rec=guixWidgetKeyRectGet(obj,aw,ah,xgc,ygc, gx,gy,gw,gh,3,3);
 fs=(rec.h/2)+fad;
 fs-=3;
 guixWidgetKeyPaint(obj,rec.x,rec.y,rec.w,rec.h,fs,1000+(what*100)+150,"PST",2);


 gx=87; gy=55; gw=12; gh=22;
 rec=guixWidgetKeyRectGet(obj,aw,ah,xgc,ygc,gx,gy,gw,gh,3,3);
 fs=(rec.h/2)+fad;
 guixWidgetKeyPaint(obj,rec.x,rec.y,rec.w,rec.h,fs,1000+(what*100)+300,aa.guiUni("u2190"),3);


 gx=20; gy=80; gw=60; gh=30;
 rec=guixWidgetKeyRectGet(obj,aw,ah,xgc,ygc,gx,gy,gw,gh,3,3);
 fs=(rec.h/2)+fad;
 guixWidgetKeyPaint(obj,rec.x,rec.y,rec.w,rec.h,fs,1000+(what*100)+400,"SPACE",1);


 gx=87; gy=85; gw=12; gh=22;
 rec=guixWidgetKeyRectGet(obj,aw,ah,xgc,ygc,gx,gy,gw,gh,3,3);
 fs=(rec.h/2)+fad;
 fs-=3;
 guixWidgetKeyPaint(obj,rec.x,rec.y,rec.w,rec.h,fs,1000+(what*100)+500,"GO",5);

 switch(what)
  {
  case 0:
  gx=1; gy=85; gw=12; gh=22;
  rec=guixWidgetKeyRectGet(obj,aw,ah,xgc,ygc,gx,gy,gw,gh,3,3);
  fs=(rec.h/2)+fad;
  fs-=3;
  guixWidgetKeyPaint(obj,rec.x,rec.y,rec.w,rec.h,fs,1000+(what*100)+301,"ABC",4);
  break;

  case 1:
  gx=1; gy=85; gw=12; gh=22;
  rec=guixWidgetKeyRectGet(obj,aw,ah,xgc,ygc,gx,gy,gw,gh,3,3);
  fs=(rec.h/2)+fad;
  fs-=3;
  guixWidgetKeyPaint(obj,rec.x,rec.y,rec.w,rec.h,fs,1000+(what*100)+302,"123",4);
  break;

  case 2:
  gx=1; gy=85; gw=12; gh=22;
  rec=guixWidgetKeyRectGet(obj,aw,ah,xgc,ygc,gx,gy,gw,gh,3,3);
  fs=(rec.h/2)+fad;
  fs-=3;
  guixWidgetKeyPaint(obj,rec.x,rec.y,rec.w,rec.h,fs,1000+(what*100)+303,"#+=",4);
  break;

  case 3:
  gx=1; gy=85; gw=12; gh=22;
  rec=guixWidgetKeyRectGet(obj,aw,ah,xgc,ygc,gx,gy,gw,gh,3,3);
  fs=(rec.h/2)+fad;
  fs-=3;
  guixWidgetKeyPaint(obj,rec.x,rec.y,rec.w,rec.h,fs,1000+(what*100)+304,"abc",4);
  break;
  }

 // grp.vars.spot.count++;
 if(cfg_spot_show==true)
  {
  for(i=0;i<grp.vars.spot.count;i++)
   {
   spt=grp.vars.spot.ray[i];
   aa.guiCanvasBorder(grp.han,spt.x,spt.y,spt.w,spt.h,2,aa.guiRgbaStringCommon(8,1));
   }
  }
 }






 function guixWidgetKeyRectGet (obj,awid,ahit,wuns,huns,x,y,w,h,ha,va)
 {
 //aa.debugAlert();
 var ww,hh,wu,hu,grp,rect;
 if(obj==undefined)        { return false; }
 if(obj.type!="widget")    { return false; }
 if(obj.cat!="keyboard")   { return false; }

 //over-ride the sensor area
 ha=-8;
 va=-8;
 //ha=va=10;
 ha=va=0;
 grp=obj.grp;
 ww=awid;
 hh=ahit;
 wu=(ww/wuns);//>>0;
 hu=(hh/huns);//>>0;
 rect=aa.guiRectSet((x*wu),(y*hu),w*wu,h*hu);
 return rect;
 }



 function guixWidgetKeyPaint (obj,x,y,w,h,fs,spid,key,uv2)
 {
 var grp,fnt,mes,fw,fh,sl,grad,txt,rs;
 if(obj==undefined)      { return; }
 if(obj.type!="widget")  { return; }
 if(obj.cat!="keyboard") { return; }
 grp=obj.grp;
 if(0) { grp.obj.ctx.save(); }
 x=(x>>0);
 y=(y>>0);
 w=(w>>0);
 h=(h>>0);
 aa.guiCanvasRounded(grp.han,x,y,w,h, obj.vars.key_rounded_radius ,1,obj.vars.rgba_key_border,obj.vars.rgba_key_bg);
 if(0) { aa.guiCanvasSmoothingSet(grp.han,true,1,2,3,obj.vars.rgba_key_smooth); }
 fnt="400 "+(fs)+"px '"+"arial"+"'";
 aa.guiCanvasFontSet(grp.han,fnt);
 mes=aa.guiCanvasTextMeasure(grp.han,key);
 fw=mes.w;
 fh=mes.h;
 sl=key.length;
 aa.guiCanvasText(grp.han,((x+(w/2))-((fw)/2))+1,((y+(h/2))-(fh/2)-0)+1,0,null,aa.guiRgbaString(0x0,0x0,0x0,1.0),fnt,key);
 aa.guiCanvasText(grp.han,(x+(w/2))-((fw)/2),(y+(h/2))-(fh/2)-0,0,null,obj.vars.rgba_key_fg,fnt,key);
 if(0) { aa.guiCanvasSmoothingSet(grp.han,false,2,6,8,obj.vars.rgba_smooth); }//aa.guiRgbaString(0x1f,0xff,0xff,1.0));
 if(0) { grp.obj.ctx.restore(); }
 if(spid!=0&&1)
  {
  aa.guiSpotAdd(grp.han,spid,x-5,y-5,w+10,h+10, key ,uv2 , obj.guc);

  }
 }



/*-----------------------------------------------------------------------*/

 function guixWidgetChatLogNew (canvasid,uid,msgproc)
 {
 var obj,what,chs,grp,hud,i,lob;
 grp=guixGroupGet(canvasid);
 if((obj=aa.guiWidgetNew("chatlog",grp.obj.id,uid,msgproc))==null) { aa.debugAlert("widget new chatlog failed");  return null;  }
 obj.vars.tot_rows=5;
 obj.vars.top_row=0;//100-obj.vars.tot_rows-0;
 obj.vars.line=[];
 for(i=0;i<100;i++)
  {
  lob={};
  lob.txt="";
  lob.from=0;
  lob.img_pos=i;
  obj.vars.line[i]=lob;
  }
 obj.vars.id=grp.obj.id;
 obj.vars.grp=grp;
 obj.vars.rgba_bg=aa.guiRgbaString(100,100,120,1.0)
 obj.vars.rgba_fg=aa.guiRgbaString(20,23,15,1.0);
 obj.vars.rgba_common=aa.guiRgbaStringCommon(0,1);
 obj.vars.ipos=0;
 obj.vars.shade=0;
 obj.vars.needs_paint=true;
 return obj;
 }



 function guixRoomEntry (obj)
 {
 var dsz,grp,fnt,area;
 grp=guixGroupGet("b_chatlog_0");
 area=aa.guiCssAreaGet(grp.han);
 console.log(area);
 fnt=aa.guiFontString(500,24,"arial");
 aa.guiCanvasText(grp.han,10,10,0,null,aa.guiRgbaStringCommon(0,1),fnt,"Room name");



 }


 function guixWidgetChatLogPaint (obj)
 {
 var area,fs,fnt,i,j,y,cmn,grp,grpb,dsz,hh,vil,lob,hm,vm,wid,rat;

 if(app.in_call==false)
  {
  guixRoomEntry(obj);
  return;
  }

 dsz=aa.ifaceDisplaySizesGet();
 grp=obj.grp;

 dsz=aa.ifaceDisplaySizesGet();
 rat=(dsz[5]/dsz[8]);
 //if(rat>1.0) { obj.vars.tot_rows=4; }
 //else        { obj.vars.tot_rows=6; }

// obj.vars.tot_rows=3;
 aa.guiCanvasFillFull(grp.han,obj.vars.rgba_bg);
 area=aa.guiCssAreaGet(grp.han);
 vil=obj.vars.tot_rows;
 fs=(area.height/vil);
 fs=fs>>0;

//oalert(fs);
 //if(area.width<640) { fs=48; }
 //else               { fs=32; }

 //guixLenseHudLog(app.guix.lense," "+rat);

 ///alert(area.width);
 //alert(rat+" "+fs);
 //if(area.width<640)  { fs=96; }
 //else                { alert(fs); }

 if(rat<1)
  {
  //fs=64;
  //fnt=aa.guiFontString(500,fs,"courier");
  fnt=aa.guiFontString(500,24,"arial");
  }
 else
  {
  fnt=aa.guiFontString(500,18,"arial");
  //fs=32;
  }
 //fnt=aa.guiFontString(500,fs,"courier");
 //if(area.width<640)  { fnt=aa.guiFontString(500,fs,"courier"); }
 //else                { fnt=aa.guiFontString(500,fs,"arial"); }
 y=0;
 //console.log("obj.vars.line.leng="+obj.vars.line.length);
 for(i=0;i<obj.vars.tot_rows;i++)
  {
  j=obj.vars.top_row+i;
  lob=obj.vars.line[j];
  vm=Math.floor(lob.img_pos/10);
  hm=lob.img_pos%10;
  if(lob.from==0) { continue; }
  wid=cfg_chatpix_width/cfg_chatpix_height;
  //wid=Math.floor(fs*wid);
 // if(area.width<640) { wid=Math.floor((fs*0.75)*wid); }
//  else               { wid=Math.floor(fs*wid); }

  if(rat<1)          { wid=Math.floor((fs*0.75)*wid); }
  else               { wid=Math.floor(fs*wid); }

  if(((obj.vars.shade+i)%2)==0)   {   aa.guiCanvasFill(grp.han,0,y,area.width,fs,aa.guiRgbaString(170,170,230,1.0));   }
  else                            {   aa.guiCanvasFill(grp.han,0,y,area.width,fs,aa.guiRgbaString(210,210,210,1.0));   }

  //hm*cfg_chatpix_width,vm*cfg_chatpix_height,cfg_chatpix_width,cfg_chatpix_height, 0,y,wid,fs,grpb.obj.dom);
  //obj.vars.shade=0;
   aa.guiCanvasText(grp.han,wid+5,y+2,0,null,obj.vars.rgba_fg,fnt,lob.txt);//lob.from+"  "+lob.txt+"  "+lob.img_pos+"  "+fs+"  "+wid);
   grpb=guixGroupGet("b_chatpix_0");
   aa.guiCanvasImageDraw(grp.han,hm*cfg_chatpix_width,vm*cfg_chatpix_height,cfg_chatpix_width,cfg_chatpix_height, 0,y,wid,fs,grpb.obj.dom);
   aa.guiCanvasBorder(grp.han,0,y,wid,fs,2,aa.guiRgbaStringCommon(0,1));
   aa.guiCanvasBorder(grp.han,0,y,area.width,fs,2,aa.guiRgbaStringCommon(0,1));
  y+=fs;
  }
// guixNeedsPaintSet("b_chatlog_0");
 }





 function guixWidgetChatLogLog (obj,fromid,txt)
 {
 var i,lines,line,grp,peer,grp,grpb,n,lob,tob,fid,img,rect,hm,vm;
 if(0) { console.log(arguments.callee.name+"  "+txt); }
 grp=obj.grp;
 if(fromid==null) { fid=0; }
 else             { fid=fromid; }

 peer=beamPeerById(app.beam.sh1,fid);
 //console.log(peer);
 ///console.log(fromid+" "+peer.phaze+" "+txt+"  "+peer.self_index);
 if(peer.phaze==2000||peer.phaze==200)
  {
  obj.vars.shade++;
  obj.vars.ipos++;
  obj.vars.ipos%=100;
  obj.vars.line=aa.dataArrayRotate(obj.vars.line,false);
  lob=obj.vars.line[obj.vars.tot_rows-1];
 // lob=obj.vars.line[99];//obj.vars.tot_rows-1];
  lob.txt=txt;
  lob.from=fid;
  lob.img_pos=obj.vars.ipos;
  vm=Math.floor(lob.img_pos/10);
  hm=lob.img_pos%10;
  //console.log("PEER SI="+peer.self_index);

  grpb=guixGroupGet("b_chatpix_0");
  if(peer.self_index==0)
   {
   grp=guixGroupGet("b_canstream_"+peer.self_index);
   aa.guiCanvasImageDraw(grpb.han,0,0,320,240, hm*cfg_chatpix_width,vm*cfg_chatpix_height,cfg_chatpix_width,cfg_chatpix_height,grp.obj.dom);
   }
  else
   {
   grp=guixGroupGet("b_video_"+peer.self_index);
   aa.guiCanvasImageDraw(grpb.han,0,0,grp.dom.videoWidth,grp.dom.videoHeight, hm*cfg_chatpix_width,vm*cfg_chatpix_height,cfg_chatpix_width,cfg_chatpix_height,grp.obj.dom);
   }

  //aa.guiCanvasImageDraw(grpb.han,hm*80,vm*60,grp.dom.videoWidth,grp.dom.videoHeight, 0,0,80,60,grp.obj.dom);
  //aa.guiCanvasImageDraw(grpb.han,0,0,grp.dom.videoWidth,grp.dom.videoHeight, hm*cfg_chatpix_width,vm*cfg_chatpix_height,cfg_chatpix_width,cfg_chatpix_height,grp.obj.dom);


/*
  if(peer.self_index==0)
   {
   //grp=guixGroupGet("b_video_"+peer.self_index);
   //grp=guixGroupGet("b_canstream_"+peer.self_index);
   //console.log(grp.obj.id);
   //grp=guixGroupGet("b_vippy_"+peer.self_index);
   ///console.log(grp.dom.videoWidth,grp.dom.videoHeight);
   }
  else
   {
   grp=guixGroupGet("b_video_"+peer.self_index);
   }
  grpb=guixGroupGet("b_chatpix_0");
  //aa.guiCanvasImageDraw(grpb.han,hm*80,vm*60,grp.dom.videoWidth,grp.dom.videoHeight, 0,0,80,60,grp.obj.dom);
  aa.guiCanvasImageDraw(grpb.han,0,0,grp.dom.videoWidth,grp.dom.videoHeight, hm*cfg_chatpix_width,vm*cfg_chatpix_height,cfg_chatpix_width,cfg_chatpix_height,grp.obj.dom);
  */
  }
 ///console.log("PEER phaze="+peer.phaze+"  "+fromid+"  "+txt);

 obj.vars.needs_update=true;
 grp.vars.needs_paint=true;
 guixNeedsPaintSet(null);
 return true;
 }






/*-----------------------------------------------------------------------*/

 function guixWidgetFieldNew (canvasid,uid,msgproc)
 {
 var obj,what,chs,grp,dsz;
 ///dsz=aa.ifaceDisplaySizesGet();
 grp=guixGroupGet(canvasid);
 if((obj=aa.guiWidgetNew("field",grp.obj.id,uid,msgproc))==null) { aa.debugAlert("widget new field failed");  return null;  }
 obj.vars.clipboard="";
 obj.vars.txt="";//nuke";//text";
 obj.vars.txt_start=0;
 obj.vars.caret_pos=0;
 obj.vars.caret_state=1;
 obj.vars.caret_style=0;
 obj.vars.sel_state=false;
 obj.vars.sel_start=0;
 obj.vars.sel_end=0;
 obj.vars.sel_chars=0;

 obj.vars.rgba_blur=aa.guiRgbaString(0xc8,0xc8,0xc8,1.0);
 obj.vars.rgba_bg=aa.guiRgbaString(0x36,0x38,0x58,1.0);
 obj.vars.rgba_fg=aa.guiRgbaString(0xc8,0xc8,0xc8,1.0);
 obj.vars.rgba_caret=aa.guiRgbaString(0xa8,0xa2,0xa5,0.7);
 obj.vars.rgba_sel_bg=aa.guiRgbaString(0xaa,0x36,0xaa,1);
 obj.vars.rgba_sel_fg=aa.guiRgbaString(0xf8,0xf8,0x28,1);

 obj.vars.font_size=10;
 obj.vars.font_string=aa.guiFontString(400,obj.vars.font_size,"arial");

 obj.vars.rect=aa.guiRectSet(210,10,20,20);

 grp=aa.guiGroupGetById(canvasid);
 mes=aa.guiCanvasFontMeasure(grp.han,obj.font_string,"W");
 obj.vars.font_wid=Math.ceil(mes.w);

 obj.vars.is_focused=true;
 obj.vars.needs_update=true;
 return obj;
 }





 function guixWidgetFieldPaint (obj)
 {
 var grp,area,what,chs,i,rec,fs;
 var txt,yoff,mes,box,rhs,brd;

 if(obj==undefined)      { return; }
 if(obj.type!="widget")  { return; }
 if(obj.cat!="field")    { return; }

 grp=obj.grp;
 area=aa.guiCssAreaGet(grp.han);

 obj.vars.font_size=area.height*0.7;
 obj.vars.font_string=aa.guiFontString(400,obj.vars.font_size,"arial");

 // the liquad crystal display
 area=aa.guiCssAreaGet(grp.han);
 brd=0;
 obj.vars.rect=aa.guiRectSet(brd,brd,area.width-(brd*2),area.height-(brd*2));//200,30);

 grp.ctx.save();
 grp.ctx.beginPath();
 grp.ctx.rect(obj.vars.rect.x,obj.vars.rect.y,obj.vars.rect.w,obj.vars.rect.h);
 grp.ctx.clip();

 txt=obj.vars.txt;
 txt=txt.substring(obj.vars.txt_start);
 yoff=((obj.vars.rect.h/2)-(obj.vars.font_size/2))-1; // was +1
 if(yoff<0) { yoff=0; }

 while(1)
  {
  mes=aa.guiCanvasFontMeasure(grp.han,obj.vars.font_string,txt);
  box=aa.guiRectSet(obj.vars.rect.x,obj.vars.rect.y,mes.w,mes.h);
  rhs=box.w;
  if(rhs<(obj.vars.rect.w)) { break; }
  txt=aa.stringLastCharTrim(txt);
  }


 if(obj.vars.is_focused==true)
  {
  aa.guiCanvasFill(grp.han,obj.vars.rect.x,obj.vars.rect.y,obj.vars.rect.w,obj.vars.rect.h,obj.vars.rgba_bg);
 // aa.guiCanvasFill(grp.han,obj.vars.rect.x,obj.vars.rect.y,obj.vars.rect.w,obj.vars.rect.h,aa.guiRgbaStringCommon(aa.numRand(20),1));//obj.vars.rgba_bg);
 // aa.guiCanvasFill(grp.han,obj.vars.rect.x,obj.vars.rect.y,obj.vars.rect.w,obj.vars.rect.h,guixRandRgba());
  }
 else
  {
  aa.guiCanvasFill(grp.han,obj.rect.x,obj.rect.y,obj.rect.w,obj.rect.h,obj.vars.rgba_blur);
  //aa.guiCanvasFill(grp.han,obj.rect.x,obj.rect.y,obj.rect.w,obj.rect.h,aa.guiRgbaStringCommon(aa.numRand(20),1));//obj.vars.rgba_blur);
  //aa.guiCanvasFill(grp.han,obj.rect.x,obj.rect.y,obj.rect.w,obj.rect.h,guixRandRgba());//aa.guiRgbaStringCommon(aa.numRand(20),1));//obj.vars.rgba_blur);
  }

 // the actual field
 aa.guiCanvasText(grp.han,box.x,box.y+yoff,0,null,obj.vars.rgba_fg,obj.vars.font_string,txt); ///===========

 if(obj.vars.sel_state==true)
  {
  sem=aa.guiCanvasFontMeasure(grp.han,obj.vars.font_string,txt);
  etc=txt;
  fron=txt;
  for(i=obj.vars.txt_start;i<obj.vars.sel_start;i++) {   fron=aa.stringFirstCharTrim(fron); }
  while(1)
   {
   if(fron.length>obj.vars.sel_chars) { fron=aa.stringLastCharTrim(fron); }
   else                               { break; }
   }
  sef=aa.guiCanvasFontMeasure(grp.han,obj.vars.font_string,fron);
  for(i=obj.vars.txt_start;i<obj.vars.sel_start;i++) {   etc=aa.stringFirstCharTrim(etc); }
  sez=aa.guiCanvasFontMeasure(grp.han,obj.vars.font_string,etc);
  dif=sem.w-sez.w;
  aa.guiCanvasFill(grp.han,box.x+dif,obj.rect.y,sef.w,obj.rect.h,obj.vars.rgba_sel_bg);
  aa.guiCanvasText(grp.han,box.x+dif,box.y+yoff,0,null,obj.vars.rgba_sel_fg,obj.vars.font_string,fron); ///===========
  }
 if(obj.vars.is_focused==true&&obj.vars.caret_state==1)
  {
  str=txt;
  str=str.substring(0,obj.vars.caret_pos-obj.vars.txt_start);
  mes=aa.guiCanvasFontMeasure(grp.han,obj.vars.font_string,str);
  box=aa.guiRectSet(box.x,box.y,mes.w,mes.h);
  if(aa.env_obj.state.is_focus==true)
   {
   switch(obj.vars.caret_style)
    {
    case 0:
    //alert(obj.vars.font_wid);
    aa.guiCanvasFill(grp.han,box.x+box.w,box.y,obj.vars.font_wid,obj.vars.rect.h-2,obj.vars.rgba_caret);
    //aa.guiCanvasFill(grp.han,box.x+box.w+2,box.y+1,4,obj.vars.rect.h-2,obj.vars.rgba_caret);
    break;

    case 1:
    mes=aa.guiCanvasFontMeasure(grp.han,obj.vars.font_string,txt.charAt(obj.vars.caret_pos));
    if(mes.w==0) { mes=aa.guiCanvasFontMeasure(grp.han,obj.vars.font_string," ");  }
    aa.guiCanvasFill(grp.han,box.x+box.w+1,(box.y+box.h+yoff)-2,mes.w-1,2,obj.vars.rgba_caret);
    break;
    }
   }
  if((box.w+(obj.vars.font_wid*1))>obj.vars.rect.w)
   {
   obj.vars.txt_start+=1;
   /////aa.miscWidgetFlagsSet(obj,true,null);
   obj.vars.needs_update=true;
   grp.ctx.restore();
   obj.vars.caret_state=2;
   return true;
   }
  }
 ///aa.miscWidgetFlagsSet(obj,false,null);
 aa.guiCanvasBorder(grp.han,obj.vars.rect.x,obj.vars.rect.y,obj.vars.rect.w,obj.vars.rect.h,1,aa.guiRgbaStringCommon(0,1));
 obj.vars.needs_update=false;
 grp.ctx.restore();
 return true;
 }






 function guixWidgetFieldCaretPosAdjust (obj,amount)
 {
 if(obj==undefined)      { return false; }
 if(obj.type!="widget")   { return false; }
 if(obj.cat!="field")     { return false; }
 if(amount>0)
  {
  amount=Math.abs(amount);
  obj.vars.caret_pos+=amount;
  if(obj.vars.caret_pos>obj.vars.txt.length) { obj.vars.caret_pos=obj.vars.txt.length;  }
  }
 else
  {
  amount=Math.abs(amount);
  obj.vars.caret_pos-=amount;
  if(obj.vars.caret_pos<0) { obj.vars.caret_pos=0;  }
  if(obj.vars.caret_pos<obj.vars.txt_start)  {   obj.vars.txt_start=obj.vars.caret_pos;   }
  }
 return true;
 }





 function guixWidgetFieldCaretHandler (obj)
 {
 var mod;

 if(obj==undefined)      { aa.debugAlert(); }
 if(obj==undefined)      { return false; }
 if(obj.type!="widget") { aa.debugAlert(); }
 if(obj.cat!="field") { aa.debugAlert(); }
 mod=((aa.iface_obj.blit_counter%40)<20)>>0;
 if(obj.vars.caret_state==2) { aa.debugAlert(); }
 if(obj.vars.caret_state==2)   { aa.debugAlert();  obj.vars.caret_state=1; obj.vars.needs_update=true; }
 else
  {
  if(obj.vars.caret_state==0&&mod==1)  {  obj.vars.caret_state=1; obj.vars.needs_update=true;}
  else
  if(obj.vars.caret_state==1&&mod==0)  {  obj.vars.caret_state=0; obj.vars.needs_update=true; }
  }
 if(obj.vars.needs_update==true)
  {
  obj.grp.vars.needs_paint=true;
  obj.vars.needs_update=false;
  }
 return true;
 }





 function guixWidgetFieldEmulateKey (obj,key)
 {
 var mask,len,cmd,myid,grp,i,spt,area;
 if(obj==undefined)      { return false; }
 if(obj.type!="widget")   { return false; }
 if(obj.cat!="field")     { return false; }

 ///console.log("aswaaaaaaaaa");

 grp=guixGroupGet("b_kbcanvas_0");
 spt=null;
 for(i=0;i<grp.vars.spot.count;i++)
  {
  spt=grp.vars.spot.ray[i];
  if(spt.uv1==key.key)
   {
   break;
   //console.log(spt);
   }
  //aa.guiCanvasBorder(grp.han,spt.x,spt.y,spt.w,spt.h,2,aa.guiRgbaStringCommon(8,1));
  }
 if(i==grp.vars.spot.count) { spt=null; }


/// console.log(key.name+"  "+key.key+"  '"+obj.vars.txt+"' ");
 while(1)
  {
  if(key==null)           { break; }
  ///console.log(key.name+"  "+key.key+"  '"+obj.vars.txt+"' ");
  if(key.name!="keydown") { break; }
  obj.vars.needs_update=true;
  while(1)
   {
   mask=0;
   if(key.alt_key==true)   { mask+=1; }
   if(key.ctrl_key==true)  { mask+=2; }
   if(key.shift_key==true) { mask+=4; }

   if(key.key==aa.guiUni("u2190")||key.key=="Backspace")
    {
    console.log("backsopa");
    len=1;
    if(obj.vars.sel_state==true)
     {
     len=obj.vars.sel_chars;
     obj.vars.txt=aa.stringDelete(obj.vars.txt,obj.vars.sel_start,obj.vars.sel_chars);
     obj.vars.sel_chars=0;
     obj.vars.sel_state=false;
     }
    //console.log("txt=["+obj.vars.txt+"] cpos="+obj.vars.caret_pos);
    console.log("pre="+obj.vars.txt);
    guixWidgetFieldCaretPosAdjust(obj,-len);
    //console.log("new cpos="+obj.vars.caret_pos);
    obj.vars.txt=aa.stringDelete(obj.vars.txt,obj.vars.caret_pos)
    obj.grp.vars.needs_paint=true;
    obj.vars.needs_update=true;
    console.log("post="+obj.vars.txt);
    break;
    }

  if(key.key=="SPACE")
   {
   if(obj.vars.sel_state==true)
    {
    len=obj.vars.sel_chars;
    obj.vars.txt=aa.stringDelete(obj.vars.txt,obj.vars.sel_start,len);
    obj.vars.sel_chars=0;
    obj.vars.caret_pos=obj.vars.sel_start;
    }
   obj.vars.sel_state=false;
   obj.vars.txt=aa.stringInsert(obj.vars.txt,obj.vars.caret_pos," ");
   obj.vars.caret_pos++;
     obj.grp.vars.needs_paint=true;
     obj.vars.needs_update=true;
   break;
   }

   if(key.key=="Enter")
    {
    cmd=app.guix.widget_chatfield.vars.txt;
    if(app.beam!==undefined)
     {
     if(app.beam.sh1!==undefined)
      {
      myid=app.beam.sh1.my_id;
      beamAnnounce(app.beam.sh1,cmd);
      //guixWidgetChatLogLog(app.guix.widget_chatlog,myid,cmd);
      }
     }
    app.guix.widget_chatfield.vars.txt="";
    app.guix.widget_chatfield.vars.txt_start=0;
    app.guix.widget_chatfield.vars.caret_pos=0;

    break;
    }


   if(mask==0||mask==4)
    {
    if(key.key.length==1)
     {
     if(obj.vars.sel_state==true)
      {
      len=obj.vars.sel_chars;
      obj.vars.txt=aa.stringDelete(obj.vars.txt,obj.vars.sel_start,len);
      obj.vars.sel_chars=0;
      obj.vars.caret_pos=obj.vars.sel_start;
      }
     obj.vars.sel_state=false;
     ///console.log("mask ="+mask+"  cpos="+obj.vars.caret_pos);
     obj.vars.txt=aa.stringInsert(obj.vars.txt,obj.vars.caret_pos,key.key);
     obj.vars.caret_pos++;
     obj.grp.vars.needs_paint=true;
     obj.vars.needs_update=true;


     if(spt==null)
      {
      area=aa.guiCssAreaGet(grp.han);
///      guixAniBubbleNew(aa.numRand(area.width),area.top+aa.numRand(100),key.key);//spt.uv1);//aa.numRandValue(0,500),document.documentElement.clientHeight-50,key.key);
      }
     else
      {
      area=aa.guiCssAreaGet(grp.han);
///      guixAniBubbleNew(area.left+spt.x+32,area.top+spt.y+aa.numRand(32),spt.uv1);//aa.numRandValue(0,500),document.documentElement.clientHeight-50,key.key);
      }

     //guixAniBubbleNew(aa.numRandValue(0,500),document.documentElement.clientHeight-50,key.key);
     break;
     }
    return false;
    }

   //console.log("spotHit"+mesg.spos.uv1+"  "+aa.guiUni("u2190"));
   break;
   }
  break;

  }
 return true;
 }











/*-----------------------------------------------------------------------*/

/*
https://www.webrtc-experiment.com/docs/how-file-broadcast-works.html
var chunkLength = 1000;

function onReadAsDataURL(event, text) {
    var data = {}; // data object to transmit over data channel
    if (event) text = event.target.result; // on first invocation

    if (text.length > chunkLength)
    {
        data.message = text.slice(0, chunkLength); // getting chunk using predefined chunk length
    }
    else
    {
        data.message = text;
        data.last = true;
    }
    dataChannel.send(data); // use JSON.stringify for chrome!

    var remainingDataURL = text.slice(data.message.length);
    if (remainingDataURL.length) setTimeout(function ()
    {
        onReadAsDataURL(null, remainingDataURL); // continue transmitting
    }, 500)
}

 function fopen ()
 {
 var input = document.createElement('input');
 input.type = 'file';
 input.onchange=e=>
  {
  var file=e.target.files[0];
  //guixLenseHudLog(app.guix.lense,"file="+file);
  //console.log(file);
  var reader = new window.FileReader();
  reader.readAsDataURL(file);
  reader.onload = onReadAsDataURL;
  }
 input.click();
 }


*/

 function inviteOthers ()
 {
 var url,lnk,txt,tit;
 txt="Requesting a video call with you!\n\n";
 lnk="https://apakian.online/simple-aa-js-demo";
 tit="apakian.online\n";
 //tit="Meet Me at MeBeam\n";
 if(navigator.share)
  {
  console.log("have share")
  navigator.share({title:tit,text:txt,url:lnk})
  .then(()=>
   {
   console.log("invite ok");
   })
  .catch((error)=>
   {
   //console.log("error "+error.name+"  "+error.message);
   });
  }
 else
  {
  console.log("f");
  return false;
  }
  console.log("t");
 return true;
 }



/*-----------------------------------------------------------------------*/





 function ptrStart ()
 {
 app.ptr={};

 app.ptr.is_dragging=0;
 app.ptr.dragging_what=null;
 app.ptr.init_e=null;
 app.ptr.prev_e=null;
 app.ptr.this_e=null;
 //app.ptr.dirc_e=null;
 app.ptr.dirc_x=0;
 app.ptr.dirc_y=0;
 app.ptr.dirc_ms=0;
 app.ptr.direction={x:0,y:0};
 app.ptr.is_animating=false;
 app.ptr.animate_left=0;
 app.ptr.animate_add=0;
 app.ptr.animate_dir=0;
 app.ptr.animate_sy=0;
 //app.ptr.sy=0;
 //app.ptr.cal={};
 aa.pointerStart();
 aa.keyboardStart();
 }





 function ptrYield ()
 {
 var x2,y2,m2,x1,y1,m1,x3,y3,m3,mat1,mat2,grp1,grp2,by;
 var grp,area,spos,j,item,key,rat,fs,poy,_e;
 var fin,delt,ielt,dx,dy,str,lay0,lay1,ischg,speed,tima,abv,axe;
 var cgx,cgy,wl;

 if(app.ptr===undefined) { return; }
 while(1)
  {
  key=aa.keyboardRead();
  if(key==null) { break; }
  if(key.name=="keydown")
   {
   if(key.key=="Control")
    {
    //console.log(app.guix.widget_chatlog.vars.top_row);
   // app.guix.widget_chatlog.vars.top_row--;
    //guixWidgetChatLogPaint(app.guix.widget_chatlog);

    // guixCreate("canvas","b_kbcanvas_0",9930,guixMsgProc);
    app.guix.widget_keyboard.vars.needs_update=true;
    grp=guixGroupGet("b_kbcanvas_0");
    grp.vars.needs_paint=true;
    app.guix.widget_keyboard.vars.cur_keyboard++;
    app.guix.widget_keyboard.vars.cur_keyboard%=4;
    }
   else
    {
    //console.log(key);
   //  console.log("about to call field emulate key");
    guixWidgetFieldEmulateKey(app.guix.widget_chatfield,key);
    }
   }
  }

 fin=false;
 while(1)
  {
  rat=aa.pointerRead();
  if(rat==null) { break; }


  switch(rat.event.type)
   {
   case "pointerleave":
   case "pointerout":
   case "pointercancel":
   break;



   case "pointerdown":
   x2=rat.event.pageX;
   y2=rat.event.pageY;
   mat=aa.guiElementFromPoint(x2,y2,0,9950);
   if(mat>0)
    {
    if((grp=aa.guiGroupGet(mat))==null)  { aa.debugAlert(); }
    area=aa.guiCssAreaGet(grp.han);
    ///guixLenseHudLog(app.guix.lense,grp.obj.id);
    if(grp.obj.id=="b_animlay_1")
     {
     y2-=area.top;
     y2+=app.guix.slide.vars.y_pos;
     x2-=area.left;
     x2+=app.guix.slide.vars.x_pos;
     }
    else
     {
     y2-=area.top;
     x2-=area.left;
     if((spos=aa.guiSpotMatch(grp.han,x2,y2))!=null)
      {
      //guixLenseHudLog(app.guix.lense,spos.sid);
      }
     }

    if((spos=aa.guiSpotMatch(grp.han,x2,y2))!=null)
     {
     //guixLenseHudLog(app.guix.lense,"elem="+mat+" "+spos.sid+"  "+spos.uv1+" "+spos.uv2+" "+spos.uv3);
     ///guixLenseHudLog(app.guix.lense,spos.uv1+" "+spos.uv2+" "+spos.uv3);
     if(spos.uv1=="ashod")
      {
      //fopen();
      //inviteOthers();
      aa.envGoto(300,"https://apakian.online/simple-aa-js-demo");
      }
     else
     if(spos.uv1=="share")
      {
      //fopen();
      inviteOthers();
      }
     else
     if(spos.uv1=="options")
      {
      app.guix.slide.vars.is_animating=true;
      guixTopbarPaint(guixGroupGet("b_topbar_0"));
      if(app.guix.slide.vars.dir==1)       {       app.guix.slide.vars.dir=-1;       }
      else                                 {       app.guix.slide.vars.dir=+1;       }
      ///guixLenseHudLog(app.guix.lense,"is ani="+app.guix.slide.vars.is_animating+" "+app.guix.slide.vars.dir);
      //console.log(app.guix.slide.vars.dir);
      }
     else
     if(spos.uv1=="mute")
      {
      if(app.media.is_mute==true) { app.media.is_mute=false; } else { app.media.is_mute=true; }

      mediaLocalGainMuteSet(cfg_audio_default_gain,app.media.is_mute);
      //gainval,muteval)
      guixTopbarPaint(guixGroupGet("b_topbar_0"));
      }
     else
      {
      if(spos.uv1=="head")
       {
       guixSidemenuHeadingSelect(spos.uv2);
       aa.guiLenseNeedsPaintSet(app.guix.slide,true);
       }
      else
      if(spos.uv1=="item")
       {
       //guixLenseHudLog(app.guix.lense,app.guix.slide.vars.cur_section);

       if(app.guix.slide.vars.cur_section=="Cameras")
        {
        mediaCamSwap(spos.uv3);
        aa.guiLenseNeedsPaintSet(app.guix.slide,true);
        }
       else
       if(app.guix.slide.vars.cur_section=="Mics")
        {
        mediaMicSwap(spos.uv3);
        aa.guiLenseNeedsPaintSet(app.guix.slide,true);
        }
       else
       if(app.guix.slide.vars.cur_section=="Speakers")
        {
        mediaChangeSinks(spos.uv3);
        aa.guiLenseNeedsPaintSet(app.guix.slide,true);
        }
       else
       if(app.guix.slide.vars.cur_section=="Options")
        {
        if(spos.uv3==0)
         {
         if(app.options.aud_act==true) { app.options.aud_act=false; } else { app.options.aud_act=true; }
         aa.guiLenseNeedsPaintSet(app.guix.slide,true);
         }
        else
        if(spos.uv3==1)
         {
         if(app.options.auto_hello==true) { app.options.auto_hello=false; } else { app.options.auto_hello=true; }
         aa.guiLenseNeedsPaintSet(app.guix.slide,true);
         }
        }
       else
       if(app.guix.slide.vars.cur_section=="Effects")
        {
        if(spos.uv3==0)
         {
         if(app.options.fx_censor==true) { app.options.fx_censor=false; } else { app.options.fx_censor=true; }
         aa.guiLenseNeedsPaintSet(app.guix.slide,true);
         }
        else
        if(spos.uv3==1)
         {
         if(app.options.fx_brighten==true) { app.options.fx_brighten=false; } else { app.options.fx_brighten=true; }
         aa.guiLenseNeedsPaintSet(app.guix.slide,true);
         }
        else
        if(spos.uv3==2)
         {
         if(app.options.fx_darken==true) { app.options.fx_darken=false; } else { app.options.fx_darken=true; }
         aa.guiLenseNeedsPaintSet(app.guix.slide,true);
         }
        else
        if(spos.uv3==3)
         {
         if(app.options.fx_disco==true) { app.options.fx_disco=false; } else { app.options.fx_disco=true; }
         aa.guiLenseNeedsPaintSet(app.guix.slide,true);
         }
        }
       else
       if(app.guix.slide.vars.cur_section=="Security")
        {
        }


       //if(app.options.aud_act==true) { app.options.aud_act=false; } else { app.options.aud_act=true; }
       //aa.guiLenseNeedsPaintSet(app.guix.slide,true);
       }
      }
     }
    }

   if(app.ptr.is_dragging==0)
    {
    app.ptr.is_dragging=1;
    if(grp!==undefined) {   app.ptr.dragging_what=grp.obj.id; }
    app.ptr.init_e=rat;
    app.ptr.prev_e=rat;
    app.ptr.this_e=rat;
    //app.ptr.dirc_e=rat;
    app.ptr.dirc_x=rat.event.pageX;
    app.ptr.dirc_y=rat.event.pageY;
    app.ptr.dirc_ms=rat.ms;
    app.ptr.direction.x=0;
    app.ptr.direction.y=0;
    app.ptr.is_animating=false;
    app.ptr.animate_left=0;
    app.ptr.animate_add=0;
    app.ptr.animate_dir=0;
    app.ptr.animate_sy=0;
    ///console.log("drag started");
    //guixLenseHudLog(app.guix.lense,"drag started");
    fin=true;
    }
   break;




   case "pointerup":
   if(app.ptr.is_dragging==1)
    {
    app.ptr.this_e=rat;
    app.ptr.is_dragging=0;
    delt={};
    delt.x=(app.ptr.this_e.event.pageX-app.ptr.dirc_x);
    delt.y=(app.ptr.this_e.event.pageY-app.ptr.dirc_y);
    tim=app.ptr.this_e.ms-app.ptr.dirc_ms;
    abv=Math.abs(delt.y);
    speed=(abv/tim)*1000;
    //console.log(delt.x+" "+delt.y+"  "+tim+"  "+abv+"  "+speed);
    if(delt.y!=0)
     {
     app.ptr.is_animating=true;
     app.ptr.animate_left=20;
     app.ptr.animate_add=1;
     if(delt.y<0) { app.ptr.animate_dir=-1; }
     else         { app.ptr.animate_dir=+1; }
     }
    app.ptr.dragging_what=null;
    fin=true;
    }

   x2=rat.event.pageX;
   y2=rat.event.pageY;
   mat=aa.guiElementFromPoint(x2,y2,0,9950);
   if(mat>0)
    {
    if((grp=aa.guiGroupGet(mat))==null)  { aa.debugAlert(); }
    area=aa.guiCssAreaGet(grp.han);
    y2-=area.top;
    x2-=area.left;
    if((spos=aa.guiSpotMatch(grp.han,x2,y2))!=null)
     {
     wl=app.guix.widget_ray.length;
     for(w=0;w<wl;w++)
      {
      wig=app.guix.widget_ray[w];
      if(wig.grp.obj.id!=spos.id) { continue; }
      if(wig.guc!=spos.uv3)       { continue; }
      if(wig.msgproc==null)       { continue; }
      msg={};
      msg.cmd="spothit";
      msg.spos=spos;
      //console.log(msg);
      reply=aa.guiWidgetMsgSend(wig,msg);
      msg=null;
      reply=null;
      break;
      }
     }
    }

   break;




   case "pointermove":
   if(app.ptr.is_dragging==1&&app.ptr.dragging_what=="b_animlay_1")
    {
    //guixLenseHudLog(app.guix.lense,"drag "+app.ptr.dragging_what);

    app.ptr.prev_e=app.ptr.this_e;
    app.ptr.this_e=rat;

    delt={};
    delt.x=(app.ptr.this_e.event.pageX-app.ptr.prev_e.event.pageX);
    delt.y=(app.ptr.this_e.event.pageY-app.ptr.prev_e.event.pageY);

    ielt={};
    ielt.x=(app.ptr.this_e.event.pageX-app.ptr.init_e.event.pageX);
    ielt.y=(app.ptr.this_e.event.pageY-app.ptr.init_e.event.pageY);

    dx=0;    if(delt.x<0) { dx=-1; } else    if(delt.x>0) { dx=+1; }
    dy=0;    if(delt.y<0) { dy=-1; } else    if(delt.y>0) { dy=+1; }

    cgx=0;
    if(app.ptr.direction.x==0&&dx<0) { cgx=1;  } else
    if(app.ptr.direction.x==0&&dx>0) { cgx=2;  } else
    if(app.ptr.direction.x>0 &&dx<0) { cgx=3;  } else
    if(app.ptr.direction.x>0 &&dx>0) { cgx=4;  } else
    if(app.ptr.direction.x<0 &&dx<0) { cgx=5;  } else
    if(app.ptr.direction.x<0 &&dx>0) { cgx=6;  }
    cgy=0;
    if(app.ptr.direction.y==0&&dy<0) { cgy=1;  } else
    if(app.ptr.direction.y==0&&dy>0) { cgy=2;  } else
    if(app.ptr.direction.y>0 &&dy<0) { cgy=3;  } else
    if(app.ptr.direction.y>0 &&dy>0) { cgy=4;  } else
    if(app.ptr.direction.y<0 &&dy<0) { cgy=5;  } else
    if(app.ptr.direction.y<0 &&dy>0) { cgy=6;  }

//    if( (cgx==1)||(cgx==2)||(cgx==3)||(cgx==6) ||
    if((cgx==1)||(cgx==2)||(cgx==3)||(cgx==6)) { app.ptr.dirc_x=rat.event.pageX; }
    if((cgy==1)||(cgy==2)||(cgy==3)||(cgy==6)) { app.ptr.dirc_y=rat.event.pageY; }


    //app.ptr.dirc_e=rat;
    app.ptr.direction.x=delt.x;
    app.ptr.direction.y=delt.y;

    //console.log(
    app.ptr.animate_sy-=delt.y;

    ///console.log(app.ptr.animate_sy);
    //console.log(cgx,cgy);


    app.guix.slide.vars.y_pos-=delt.y;
    if(app.guix.slide.vars.y_pos<=0)
     {
     app.guix.slide.vars.y_pos=0;
     }
    if(app.guix.slide.vars.y_pos>=app.guix.slide.vars.y_max)
     {
     app.guix.slide.vars.y_pos=app.guix.slide.vars.y_max;
     }

    //console.log(app.guix.slide.vars.y_pos+"  "+app.guix.slide.layer[0].area.height);
    aa.guiLenseNeedsPaintSet(app.guix.slide,true);



    }
   break;


   default:
   console.log("unhandled rat.event.type="+rat.event.type);
   fin=true;
   break;
   }

  if(fin==true) {  break; }
  }


 }






//-----------------------------------------------------------------------







 function mediaStart ()
 {
 app.media={};
 app.media.is_started=true;
 app.media.is_swapping=false;
 app.media.is_mute=cfg_audio_local_initially_muted;
 app.media.handle=0;
 app.media.handle2=0;
 app.media.cur_axi=0;  // current mic

 if(app.ei.who==1) // firefox
  {
  app.media.cur_vxi=0;  // current cam
  }
 else
  {
  app.media.cur_vxi=0;  // current cam
  }
  app.media.cur_vxi=2;

 if(aa.envBrowserArgByKey("vxi").val!==undefined)
  {
  app.media.cur_vxi=parseInt(aa.envBrowserArgByKey("vxi").val);
  }
 if(aa.envBrowserArgByKey("axi").val!==undefined)
  {
  app.media.cur_axi=parseInt(aa.envBrowserArgByKey("axi").val);
  }
 app.media.cur_axo=0;  // current speakers
 app.media.cur_vfxi=0; // current vid fx
 app.media.cur_afxi=0; // current aud fx
 app.media.cur_grxi=0; // current green screen fx
 app.media.cur_arxi=0; // current AR fx
 app.media.cam_swap_stage=0;
 app.media.cam_swap_vxi=0;
 app.media.mic_swap_stage=0;
 app.media.mic_swap_axi=0;
 app.media.grp_of_b_video_0=null;
 app.media.grp_of_b_canstream_0=null;
 //aa.debugAlert();
 mediaLocalGainMuteSet(cfg_audio_default_gain,cfg_audio_local_initially_muted);
 app.media.devenu=null;
 app.media.active_devenu=null;
 console.log("media started");
 }



 function mediaYield ()
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 if(app.media===undefined) { return; }
 mediaSwapYield();
 }


 /*
 function mediaLocalMuteSet (state)
 {
 if(app.media.is_mute==true&&state==false)
  {
  app.media.is_mute=false;
  app.media.cur_local_mute=false;
  app.media.cur_local_gain=cfg_audio_default_gain;
  }
 else
 if(app.media.is_mute==false&&state==true)
  {
  app.media.is_mute=true;
  app.media.cur_local_mute=true;
  app.media.cur_local_gain=0.0;
  }
 }
  */


 function mediaLocalGainMuteSet (gainval,muteval)
 {
 app.media.cur_local_gain=gainval;
 app.media.cur_local_mute=muteval;
 }





 function mediaSize (useshort,rezwid,isrot)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var ww,hh,obj;
 switch(rezwid)
  {
  default:  aa.debugAlert("rezwid="+rezwid);  break;
  case 160:  ww=rezwid;  if(useshort) { hh=90;   }  else  { hh=120; }  break;
  case 320:  ww=rezwid;  if(useshort) { hh=180;  }  else  { hh=240; }  break;
  case 640:  ww=rezwid;  if(useshort) { hh=360;  }  else  { hh=480; }  break;
  case 1280: ww=rezwid;  if(useshort) { hh=630; }  else  { hh=720;}  break;
  case 1080: ww=rezwid;  if(useshort) { hh=1200; }  else  { hh=1920;}  break;
  case 1920: ww=rezwid;  if(useshort) { hh=960;  }  else  { hh=1080;}  break;
  }
 if(isrot)  {  swp=ww;  ww=hh;  hh=swp;  }
 obj={};
 obj.w=ww;
 obj.h=hh;
 console.log(obj);
 return obj;
 }




 function mediaDeviceListInit (obj)
 {
 var o,i,l;
 app.media.active_devenu=null;
 app.media.active_devenu=JSON.parse(JSON.stringify(obj));
 l=app.media.active_devenu.aud_input_list.length;
 for(i=0;i<l;i++)
  {
  app.media.active_devenu.aud_input_list[i].res=null;
  }
 l=app.media.active_devenu.vid_input_list.length;
 for(i=0;i<l;i++)
  {
  app.media.active_devenu.vid_input_list[i].res=null;
  }
 l=app.media.active_devenu.aud_output_list.length;
 for(i=0;i<l;i++)
  {
  app.media.active_devenu.aud_output_list[i].res=null;
  }
 console.log("####### mediaDeviceList Init");
 return true;
 }




 function mediaDeviceListErr (obj,kind,index,errobj)
 {
 var oe;
 console.log("####### mediaDeviceList Err kind="+kind+"  index="+index+"");
 if(errobj!==undefined)
  {
  }
 switch(kind)
  {
  case "audioinput":   app.media.active_devenu.aud_input_list[index].res=errobj; break;
  case "videoinput":   app.media.active_devenu.vid_input_list[index].res=errobj; break;
  case "audiooutput":  app.media.active_devenu.aud_output_list[index].res=errobj; break;
  }
 if(errobj.res!="ok")
  {
  console.log("res="+errobj.res+" name="+errobj.name);
  console.log("msg="+errobj.msg+" code="+errobj.code);
  console.log("etc="+errobj.etc+" "+errobj.etc0+","+errobj.etc1);
  }
 }



 function mediaDeviceDump (doactive)
 {
 var str,len,i,eo,d,den;
 console.log(" ");
 console.log("mediaDeviceDump==========");
 if(doactive) { den=app.media.active_devenu; }
 else         { den=app.media.devenu;        }
 for(i=0;i<den.aud_input_list.length;i++)
  {
  o=den.aud_input_list[i];
  str="";
  str+="i="+i+"  ";
  str+=o.kind+"  ";
  str+=o.clean+"  ";
  if(o.res!=null)
   {
   str+="res.res="+o.res.res+" ";
   str+="res.name="+o.res.name+" ";
   str+="res.msg="+o.res.msg+" ";
   }
  console.log(str);
  }
 console.log(" ");

 for(i=0;i<den.vid_input_list.length;i++)
  {
  o=den.vid_input_list[i];
  str="";
  str+="i="+i+"  ";
  str+=o.kind+"  ";
  str+=o.clean+"  ";
  if(o.res!=null)
   {
   str+="res.res="+o.res.res+" ";
   str+="res.name="+o.res.name+" ";
   str+="res.msg="+o.res.msg+" ";
   }
  console.log(str);
  }
 console.log(" ");
 for(i=0;i<den.aud_output_list.length;i++)
  {
  o=den.aud_output_list[i];
  str="";
  str+="i="+i+"  ";
  str+=o.kind+"  ";
  str+=o.clean+"  ";
  if(o.res!=null)
   {
   str+="res.res="+o.res.res+" ";
   str+="res.name="+o.res.name+" ";
   str+="res.msg="+o.res.msg+" ";
   }
  console.log(str);
  }
 console.log(" ");
 console.log(".......");
 console.log(" ");
 }




 function mediaDeviceCountGet (kind)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 switch(kind)
  {
  case "audioinput":  return app.media.active_devenu.aud_input_list.length;
  case "audiooutput": return app.media.active_devenu.aud_output_list.length;
  case "videoinput":  return app.media.active_devenu.vid_input_list.length;
  }
 return 0;
 }



 function mediaDeviceGet (kind,index)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 switch(kind)
  {
  case "audioinput":
  if(index>=app.media.active_devenu.aud_input_list.length) { break; }
  return app.media.active_devenu.aud_input_list[index];
  case "audiooutput":
  if(index>=app.media.active_devenu.aud_output_list.length) { break; }
  return app.media.active_devenu.aud_output_list[index];
  case "videoinput":
  if(index>=app.media.active_devenu.vid_input_list.length) { break; }
  return app.media.active_devenu.vid_input_list[index];
  }
 return null;
 }



 function mediaPairCreate (axi,vxi)
 {
 var ax,vx,ox,han,wid,hit,dsz,adid,vdid,csz;
 if(axi) { ax=axi; } else { ax=0; }
 if(vxi) { vx=vxi; } else { vx=0; }
 ax%=mediaDeviceCountGet("audioinput");
 vx%=mediaDeviceCountGet("videoinput");
 app.media.cur_axi=ax;
 app.media.cur_vxi=vx;
 dsz=aa.ifaceDisplaySizesGet();
 csz=mediaSize(cfg_cam_res_short,cfg_cam_res_wid,cfg_cam_res_rot);
 wid=csz.w;
 hit=csz.h;
 adid=mediaDeviceGet("audioinput",ax);
 if(adid!=null)  {  adid=adid.deviceId;  }
 vdid=mediaDeviceGet("videoinput",vx);
 if(vdid!=null)  {  vdid=vdid.deviceId;  }
 //console.log(wid,hit);
 ///alert(">> media pair create "+axi+"  "+vxi);
 if(adid==null&&vdid==null)
  {

  }
 else
 if(adid==null&&vdid!=null)
  {
  han=aa.mediaCreate(
   {deviceId:{exact:vdid},width:{ideal:wid,max:wid},height:{ideal:hit,max:hit},frameRate:{ideal:cfg_v_fps,max:cfg_v_fps}  },
   null);
  }
 else
 if(adid!=null&&vdid==null)
  {
  }
 else
 if(adid!=null&&vdid!=null)
  {
  han=aa.mediaCreate(
   {deviceId:{exact:vdid}, width:{ideal:wid,max:wid},height:{ideal:hit,max:hit},
   frameRate:{ideal:cfg_v_fps,max:cfg_v_fps}  },
   {deviceId:{exact:adid},channelCount:1,sampleRate:{min:16000,ideal:48000,max:48000}, latency:0,
    echoCancellation:cfg_a_aec,noiseSuppression:cfg_a_nsu,autoGainControl:cfg_a_agc,
    googEchoCancellation:cfg_a_aec,googNoiseSuppression:cfg_a_nsu,googAutoGainControl:cfg_a_agc//,
    //,aspectRatio: 16/9
    //,aspectRatio: 4 / 3
   });
  }
  //aspectRatio: 4 / 3,
 return han;
 }




 function mediaCombineStreams (astream,vstream)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var stream,tr=[];
 if(astream!=undefined) { tr=tr.concat(astream); }
 if(vstream!=undefined) { tr=tr.concat(vstream); }
 stream=new MediaStream(tr);
 return stream;
 }




 function mediaAudioFreqToIndex (object,freq)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var index,res;
 index=Math.round((freq/object.freq_range)*object.band_count);
 res=aa.numClamp(index,0,object.band_count);
 return res;
 }



 function mediaAudioIndexToFreq (object,index)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var res=(index*object.rate)/(object.band_count*2);
 return res;
 }


 function mediaMicSwap (axi)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var pxi;
 //console.log("mediaMicSwap "+axi);
 if(app.media.is_swapping!=false) { console.log("swapping in use"); return false; }
 if(axi==null)                    { return false; }
 pxi=app.media.cur_axi;
 console.log("mediaMicSwap to "+axi+" cur_axi="+pxi);
 app.media.is_swapping=true;
 app.media.mic_swap_stage=1;
 app.media.mic_swap_axi=axi;
 //console.log("mic swapping  ok");
 return true;
 }



 function mediaCamSwap (vxi)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var pxi;
 if(app.media.is_swapping!=false) { return false; }
 if(vxi==null) { return false; }
 //console.log("mediaCamSwap "+vxi);
 pxi=app.media.cur_vxi;
 console.log("mediaCamSwap to "+vxi+" cur_vxi="+pxi);
 app.media.is_swapping=true;
 app.media.cam_swap_stage=1;
 app.media.cam_swap_vxi=vxi;
 return true;
 }



 function mediaSwapYield ()
 {
 if(app.media.is_swapping!=true) { return; }
/// console.log(arguments.callee.name);
 mediaSwapMicYield();
 mediaSwapCamYield();
 }



 function mediaSwapMicYield ()
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var obj,ret,mob,grp,stream,rtc,status,grpc,vstream,astream,cstream,grpv,err,oe;
 switch(app.media.mic_swap_stage)
  {
  case 0:
  return;

  case 1:
  console.log("mediaSwapMicYield stage 1, device count= "+mediaDeviceCountGet("audioinput"));
  console.log("cur axi="+app.media.cur_axi+"  swap axi="+app.media.mic_swap_axi);
  app.media.cur_axi=app.media.mic_swap_axi;
  app.media.cur_axi%=mediaDeviceCountGet("audioinput");
  app.media_handle2=mediaPairCreate(app.media.cur_axi,app.media.cur_vxi); ///!!!!!!!!!!!!!!!!!!
  app.media.mic_swap_stage=2;
  ///guixNeedsPaintSet("sidemenu");
  return;


  case 6:
  console.log("mic 666");
  break;


  case 2:
  status=aa.mediaStatus(app.media_handle2);
  obj=aa.mediaGet(app.media_handle2);
  if(obj==null) { return; }
  if(obj.res==null) { return; }
  if(obj.res=="ok")
   {
   if(app.media.grp_of_b_canstream_0==null)
    {
    app.media.grp_of_b_canstream_0=aa.guiGroupGetById("b_canstream_0");
    console.log(app.media.grp_of_b_canstream_0);
    }
   grpc=app.media.grp_of_b_canstream_0;
   if(grpc==null) { aa.debugAlert(); }
   aa.mediaAttach(app.media.handle,null);
   //== destroy media handle
   console.log("DESTROYING MEDIA HANDLE");
   aa.mediaDestroy(app.media.handle);
   if(app.media.grp_of_b_video_0==null)
    {
    app.media.grp_of_b_video_0=aa.guiGroupGetById("b_video_0");
    //app.media.grp_of_b_video_0=aa.guiGroupGetById("b_vippy_0");
    }
   ret=aa.mediaAttach(app.media_handle2,app.media.grp_of_b_video_0.han);
   app.media.handle=app.media_handle2;
   app.media_handle2=0;
   if((obj=aa.mediaGet(app.media.handle))===null) { aa.debugAlert(); }
   if(app.media.grp_of_b_video_0==null)
    {
    app.media.grp_of_b_video_0=aa.guiGroupGetById("b_video_0");
    ///app.media.grp_of_b_video_0=aa.guiGroupGetById("b_vippy_0");
    }
   grpv=app.media.grp_of_b_video_0;
   if(grpv==null) { aa.debugAlert(); }
   ///if((grpv=aa.guiGroupGet(aa.guiIdFind("b_video_0")))==null) { aa.debugAlert(); }
   grpv.vars.prev_time=0;
   grpv.vars.frame_number=0;
   grpv.vars.fps=0;
   mediaDeviceSwapperSwap();
   app.media.mic_swap_stage=0;
   ///mediaStoreLastDevice();
   app.media.is_swapping=false;
   console.log("** mic swap success axi="+app.media.cur_axi);
   console.log("--------mic");
   err=aa.mediaErrObjCreate(obj.res,obj.e_name,obj.e_msg,obj.e_code);
   mediaDeviceListErr(app.media.active_devenu,"audioinput",app.media.mic_swap_axi,err);//app.media.cur_axi,err);
   //guixNeedsPaintSet(null);
   }
  else
  if(obj.res=="err")
   {
   console.log("--------mic ");
   err=aa.mediaErrObjCreate(obj.res,obj.e_name,obj.e_msg,obj.e_code);
   mediaDeviceListErr(app.media.active_devenu,"audioinput",app.media.mic_swap_axi,err);//app.media.cur_axi,err);
   app.media.mic_swap_stage=1;
   app.media.mic_swap_axi++;
   app.media.mic_swap_axi%=mediaDeviceCountGet("audioinput");;
   //guixNeedsPaintSet(null);
   break;
   }
  return;
  }
 }



 function mediaSwapCamYield ()
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var obj,ret,mob,grp,stream,rtc,status,grpc,vstream,astream,cstream,grpv,err;
 switch(app.media.cam_swap_stage)
  {
  case 0:
  return;

  case 1:
  console.log("mediaSwapCamYield stage 1 "+mediaDeviceCountGet("videoinput"));
  console.log("cur vxi="+app.media.cur_vxi+"  swap vxi="+app.media.cam_swap_vxi);
  app.media.cur_vxi=app.media.cam_swap_vxi;
  app.media.cur_vxi%=mediaDeviceCountGet("videoinput");
  //console.log("new vxi="+app.media.cur_vxi);
  app.media_handle2=mediaPairCreate(app.media.cur_axi,app.media.cur_vxi);  ///!!!!!!!!!!!!!!!!!!
  app.media.cam_swap_stage=2;
  ///guixNeedsPaintSet("sidemenu");
  return;

  case 6:
  console.log("cam 666");
  break;


  case 2:
  status=aa.mediaStatus(app.media_handle2);
  obj=aa.mediaGet(app.media_handle2);
  if(obj==null) { return; }
  if(obj.res==null) { return; }
  if(obj.res=="ok")
   {
   if(app.media.grp_of_b_canstream_0==null)
    {
    app.media.grp_of_b_canstream_0=aa.guiGroupGetById("b_canstream_0");
    }
   grpc=app.media.grp_of_b_canstream_0;
   if(!grpc) { aa.debugAlert(); }
   aa.mediaAttach(app.media.handle,null);
   //== destroy media handle
   console.log("DESTROYING MEDIA HANDLE");
   aa.mediaDestroy(app.media.handle);
   if(app.media.grp_of_b_video_0==null)
    {
    app.media.grp_of_b_video_0=aa.guiGroupGetById("b_video_0");
    ///app.media.grp_of_b_video_0=aa.guiGroupGetById("b_vippy_0");
    }
   ///console.log("ID = "+app.media.grp_of_b_video_0.obj.id);
   if((ret=aa.mediaAttach(app.media_handle2,app.media.grp_of_b_video_0.han))!=true) { aa.debugAlert("media attach  ="+ret); }
   ///if((ret=aa.mediaAttach(app.media_handle2,aa.guiGroupGet(aa.guiIdFind("b_video_0")).han))!=true) { aa.debugAlert("media attach  ="+ret); }
   app.media.handle=app.media_handle2;
   app.media_handle2=0;
   if((obj=aa.mediaGet(app.media.handle))===null) { aa.debugAlert(); }
   grpv=app.media.grp_of_b_video_0;
   if(!grpv) { aa.debugAlert(); }
   //if((grpv=aa.guiGroupGet(aa.guiIdFind("b_video_0")))==null) { aa.debugAlert(); }
   grpv.vars.prev_time=0;
   grpv.vars.frame_number=0;
   grpv.vars.fps=0;
   mediaDeviceSwapperSwap();
   app.media.cam_swap_stage=0;
   ///mediaStoreLastDevice();
   app.media.is_swapping=false;
   console.log("** cam swap success vxi="+app.media.cur_vxi);
   err=aa.mediaErrObjCreate(obj.res,obj.e_name,obj.e_msg,obj.e_code);
   mediaDeviceListErr(app.media.active_devenu,"videoinput",app.media.cam_swap_vxi,err);//app.media.cur_axi,err);
   //guixNeedsPaintSet(null);
   aa.guiLenseNeedsPaintSet(app.guix.slide,true);
   }
  else
  if(obj.res=="err")
   {
   console.log("--------cam err");
   err=aa.mediaErrObjCreate(obj.res,obj.e_name,obj.e_msg,obj.e_code);
   mediaDeviceListErr(app.media.active_devenu,"videoinput",app.media.cam_swap_vxi,err);//app.media.cur_axi,err);
   app.media.cam_swap_stage=1;
   app.media.cam_swap_vxi++;
   app.media.cam_swap_vxi%=mediaDeviceCountGet("videoinput");;
   //guixNeedsPaintSet(null);
   aa.guiLenseNeedsPaintSet(app.guix.slide,true);
   break;
   }
  return;
  }
 }







 function mediaChangeSinks (axo)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var g,grp;
 console.log("CHANGE SINKS");
  //app.media.cur_axo=axo; return;
 axo%=mediaDeviceCountGet("audiooutput");
 for(g=0;g<cfg_peers_max;g++)
  {
  if(g==0) { continue; }
  //grp=aa.guiGroupGet(aa.guiIdFind("b_video_"+g));
  grp=aa.guiGroupGetById("b_video_"+g);

  if(grp==null)             { continue; }
  if(grp.obj.type!="video") { continue; }
//    console.log(grp.obj.id+"  "+grp.dom.videoWidth);
  if(grp.dom.videoWidth==0) { continue; }
  grp.dom.setSinkId(mediaDeviceGet("audiooutput",axo).deviceId);
  }
 app.media.cur_axo=axo;
 ///guixNeedsPaintSet("sidemenu");
 }






 function mediaDeviceSwapperInit ()
 {
 var cap_stream,vid_tracks,med_object,aud_stream,new_stream,grp,tr;
 if(0) { console.log("line number "+aa.debugLineNumber()); }
 //if((grp=aa.guiGroupGet(aa.guiIdFind("b_canstream_0")))==null) { aa.debugAlert(); }
// if((grp=aa.guiGroupGetById("b_canstream_0"))==null) { aa.debugAlert(); }
 if((grp=aa.guiGroupGetById("b_canstream_0"))==null) { aa.debugAlert(); }
 //console.log("capturing stream "+cfg_v_fps);
 //if(cfg_auto_capture_stream==true)  { cap_stream=grp.dom.captureStream();          }
 //else                               { cap_stream=grp.dom.captureStream(cfg_v_fps); }
 cap_stream=grp.dom.captureStream();
 vid_tracks=cap_stream.getVideoTracks()[0];
 med_object=aa.mediaGet(app.media.handle);
 aud_stream=med_object.a_stream;
 new_stream=mediaCombineStreams(aud_stream,vid_tracks);
 app.new_stream=new_stream;
 grp.vars.audio_processor=mediaAudioProcessorStart(grp.obj.id,new_stream);
 grp.vars.audio_processor.stream=new_stream;
 app.media.aud_pro=grp.vars.audio_processor;
 grp.vars.cst=cap_stream;
 grp.vars.nws=new_stream;
 console.log("SWAPPER INIT");
 }




 function mediaDeviceSwapperSwap ()
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var cap_stream,vid_tracks,med_object,aud_stream,new_stream,grp,tr;
 grp=aa.guiGroupGetById("b_canstream_0");
 if(grp==null) { aa.debugAlert(); }
 ///if((grp=aa.guiGroupGet(aa.guiIdFind("b_canstream_0")))==null) { aa.debugAlert(); }
 ///console.log("SWAPPER SWAP");
 //if(cfg_auto_capture_stream==true) { cap_stream=grp.dom.captureStream();      }
 //else                              { cap_stream=grp.dom.captureStream(v_fps); }

 cap_stream=grp.dom.captureStream();
 vid_tracks=cap_stream.getVideoTracks()[0];
 med_object=aa.mediaGet(app.media.handle);
 aud_stream=med_object.a_stream;
 new_stream=mediaCombineStreams(aud_stream,vid_tracks);
 app.new_stream=new_stream;
 grp.vars.audio_processor.stream=new_stream;
 grp.vars.audio_processor.microphone.disconnect();
 grp.vars.audio_processor.microphone=grp.vars.audio_processor.context.createMediaStreamSource(new_stream);
 grp.vars.audio_processor.microphone.connect(grp.vars.audio_processor.analyser);
 console.log("SWAPPER SWAP");
 }





 function mediaAudioProcessorStart (id,newlycreatedstream)
 {
 var obj,settings,sss;
 obj={};
 obj.id=id;
 obj.context=new AudioContext();
 sss=newlycreatedstream.getAudioTracks()[0];
 if(sss!=undefined)
  {
  obj.rate=sss.getSettings().sampleRate;
  obj.microphone=obj.context.createMediaStreamSource(newlycreatedstream);
  obj.destination=obj.context.createMediaStreamDestination();
  obj.scripter=obj.context.createScriptProcessor(cfg_audio_script_processor_size,1,1);
  obj.scripter.onaudioprocess=function(event) { mediaAudioProcessorProc(obj,event);  }
  obj.analyser_cycle=0;
  obj.analyser_level=0;
  obj.analyser=obj.context.createAnalyser();
  obj.analyser.fftSize=cfg_audio_fft_size;
  obj.analyser.smoothingTimeConstant=0.3;
  obj.analyser.maxDecibels=cfg_audio_max_db;
  obj.analyser.minDecibels=cfg_audio_min_db;
  obj.db_range=obj.analyser.maxDecibels-obj.analyser.minDecibels;
  obj.freq_buffer_len=obj.analyser.frequencyBinCount;
  obj.freq_float_buffer=new Float32Array(obj.freq_buffer_len);
  obj.freq_range=obj.rate/2.0;
  obj.band_count=obj.freq_buffer_len;
  obj.band_hertz=obj.freq_range/obj.band_count;
  obj.microphone.connect(obj.analyser);
  obj.analyser.connect(obj.scripter);
  obj.scripter.connect(obj.destination);
  }
 obj.stream=newlycreatedstream;
 return obj;
 }



 function mediaAudioProcessorProc (object,event)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var grp,ix;
 ///ix=aa.stringLastCharGet(object.id); if(ix!=0) { alert("ix="+ix); }
 mediaAudioAnalyzeInput(object,event);

 if(app.media.cur_local_mute==true)
  {
  mediaAudioScriptWithGain(object,event,0);
  }
 else
  {
  mediaAudioScriptWithGain(object,event,app.media.cur_local_gain);
  }
 }



 function mediaAudioAnalyzeInput (object,event)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var r,s,fqs,fqe,val,lev,dbf,suv,i,ii,mv,va,vb,dsz;
 if((object.analyser_cycle%cfg_audio_analysis_cycle)==0)
  {
  object.analyser.getFloatFrequencyData(object.freq_float_buffer);
  mv=-Infinity;
  for(i=0,ii=object.freq_buffer_len;i<ii;i++)
   {
   if(object.freq_float_buffer[i]>mv&&object.freq_float_buffer[i]<0) {  mv=object.freq_float_buffer[i];   }
   };
  suv=0;
  s=0;
  for(r=0;r<object.freq_buffer_len;r++)
   {
   //fqs=Math.round(audioIndexToFreq(object,r+0))-0;
   //fqe=Math.round(audioIndexToFreq(object,r+1))-1;
   fqs=r+0;
   fqe=r+1;
   val=object.freq_float_buffer[r];
   val-=object.analyser.minDecibels;
   ///console.log(r+" "+val);
   suv+=val**2;
   s++;
   }
  fqs=Math.round(mediaAudioIndexToFreq(object,fqs))-0;
  fqe=Math.round(mediaAudioIndexToFreq(object,fqe))-1;
  //         console.log(object.freq_buffer_len);//fqs,fqe);
  va=20*Math.log10(suv/s);
  mv=aa.numFixed(mv,1);
  va=aa.numFixed(va,1);
  lev=aa.numFixed((mv-(-160)),0);
  object.analyser_level=lev;
  }
 object.analyser_cycle++;
 }





 function mediaAudioScriptWithGain (object,event,gain)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var ibuf,obuf,ilen,i,ival,oval,minv,maxv,q;

 ibuf=event.inputBuffer.getChannelData(0);
 obuf=event.outputBuffer.getChannelData(0);
 ilen=ibuf.length;
 minv=-0.999;
 maxv=+0.999;
 for(i=0;i<ilen;i++)
  {
  ival=ibuf[i];
  oval=ival*gain;
  if(oval<minv) { oval=minv;  }
  else
  if(oval>maxv) { oval=maxv;  }
  obuf[i]=oval;
  }
 }



 function mediaCanvasPaint (dsz)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var vgrp,cgrp,vw,vh,rat,cw,ch,fps,ready,area,dw,dh,ew,eh,swp;
 if(app.media==undefined) { return; }
 //alert(app.media);
 if(app.media.is_started!=true) { return; }
 //alert(app.media.grp_of_b_video_0);
 if(app.media.grp_of_b_video_0==null)
  {
  app.media.grp_of_b_video_0=aa.guiGroupGetById("b_video_0");
  }
 vgrp=app.media.grp_of_b_video_0;
 if(vgrp.obj==null)         {   return; }
 ///guixLenseHudLog(app.guix.lense,"bmfp "+aa.main_state.cycle+" "+vgrp.dom.videoWidth+"  "+vgrp.dom.videoHeight);
 ///if(vgrp.dom.videoWidth==0)  {  return;  }
 if(app.media.grp_of_b_canstream_0==null) {  app.media.grp_of_b_canstream_0=aa.guiGroupGetById("b_canstream_0");  }
 cgrp=app.media.grp_of_b_canstream_0;
 if(cgrp.obj==null)         {  return; }
 if(cgrp.dom.videoWidth==0) {  return; }
 if(vgrp.obj.vars.fps==undefined) { vgrp.obj.vars.fps=0; }
 while(1)
  {
  if(app.media.is_swapping==true) {  ready=false; break; }
  if(vgrp.obj.dom.readyState!=4)
   {
   if(vgrp.obj.vars.prev_time!==undefined)
    {
    ///guixLenseHudLog(app.guix.lense,"Bmfp "+vgrp.obj.dom.readyState+"  "+aa.main_state.cycle);
    }
   ready=false;
   break;
   }
  if(vgrp.obj.vars.prev_time!==undefined)
   {
   //if(vgrp.obj.vars.prev_time>+"  "+vgrp.obj.dom.currentTime);
   //if(vgrp.obj.dom.currentTime<=vgrp.obj.vars.prev_time) { ready=false; break; }
   if(vgrp.obj.dom.currentTime==vgrp.obj.vars.prev_time) {  ready=false; break; }
   //if(vgrp.obj.dom.currentTime<vgrp.obj.vars.prev_time)  { ready=truee; break; }
   }
  ready=true;
  break;
  }
 //if(ready==false)  {   guixLenseHudLog(app.guix.lense,"gmfp "+aa.main_state.cycle);   }
 if(ready==true)
  {
  vw=(vgrp.obj.dom.videoWidth);
  vh=(vgrp.obj.dom.videoHeight);
  ew=vgrp.dom.width;
  eh=vgrp.dom.height;
  //rat=vw/vh;
  area=aa.guiCssAreaGet(cgrp.han);
  cw=area.width;
  ch=area.height;
  dw=cgrp.dom.width;
  dh=cgrp.dom.height;
  swp=false;
  if(vw==240&&vh==320)   {   swp=true;   }
//  guixHudLog(0,swp+"  "+vw+" "+vh+" "+ew+" "+eh+"  "+cw+" "+ch+"  "+dw+" "+dh);
  if(vgrp.obj.vars.frame_number==undefined)   {   vgrp.obj.vars.frame_number=0; }
  if(vgrp.obj.vars.frame_number==0)           {   vgrp.obj.vars.start_time=vgrp.obj.dom.currentTime;   }
  vgrp.obj.vars.frame_number++;
  vgrp.obj.vars.prev_time=vgrp.obj.dom.currentTime;
  fps=0;
  if(vgrp.obj.vars.frame_number>1) { fps=vgrp.obj.vars.frame_number/(vgrp.obj.dom.currentTime-vgrp.obj.vars.start_time);   }
  vgrp.obj.vars.fps=fps;
  // mediaFrameProcess(cgrp,cw,ch,vgrp,vh,vh);
  //guixLenseHudLog(app.guix.lense,cw+" "+ch+"  "+vw+" "+vh);
  if(swp==true)   {   mediaFrameProcess(cgrp,vw,vh,vgrp,vh,vw);   }
  else            {   mediaFrameProcess(cgrp,vw,vh,vgrp,vw,vh);   }
  }
 }






 function mediaFxCensor (wid,hit,divparm,capframe)
 {
 var xx,yy,ii,jj,r,g,b,a,i,o,rt,gt,bt,dv,cy,mul;
 if(divparm<2) { return; }
 dv=divparm;
 for(yy=0;yy<hit;yy+=dv)
  {
  for(xx=0;xx<wid;xx+=dv)
   {
   rt=gt=bt=0;
   for(ii=0;ii<dv;ii++)
    {
    for(jj=0;jj<dv;jj++)
     {
     o=((yy+ii)*wid)+xx+jj;
     r=capframe.data[o*4+0];
     g=capframe.data[o*4+1];
     b=capframe.data[o*4+2];
     rt+=r;
     gt+=g;
     bt+=b;
     }
    }
   rt=parseInt(rt/(dv*dv));
   gt=parseInt(gt/(dv*dv));
   bt=parseInt(bt/(dv*dv));
   for(ii=0;ii<dv;ii++)
    {
    for(jj=0;jj<dv;jj++)
     {
     o=((yy+ii)*wid)+xx+jj;
     capframe.data[o*4+0]=rt;
     capframe.data[o*4+1]=gt;
     capframe.data[o*4+2]=bt;
     }
    }
   }
  }
 return;
 }




 function mediaFxBrighten (wid,hit,level,capframe)
 {
 var xx,yy,r,g,b,a,i;
 if(level==1) { return; }
 for(yy=0;yy<hit;yy++)
  {
  for(xx=0;xx<wid;xx++)
   {
   i=(yy*wid)+xx;
   r=capframe.data[i*4+0]; g=capframe.data[i*4+1];  b=capframe.data[i*4+2];  a=capframe.data[i*4+3];
   r=parseInt(r*level);
   g=parseInt(g*level);
   b=parseInt(b*level);
   capframe.data[i*4+0]=r; capframe.data[i*4+1]=g;  capframe.data[i*4+2]=b;  capframe.data[i*4+3]=a;
   }
  }
 return;
 }


 function mediaFxFlashing (wid,hit,what,mul,capframe)
 {
 var xx,yy,r,g,b,a,i;
 for(yy=0;yy<hit;yy++)
  {
  for(xx=0;xx<wid;xx++)
   {
   i=(yy*wid)+xx;
   r=capframe.data[i*4+0];
   g=capframe.data[i*4+1];
   b=capframe.data[i*4+2];
   a=capframe.data[i*4+3];
   if(what==0) { r=r*mul; }   else
   if(what==1) { g=g*mul; }   else
   if(what==2) { b=b*mul; }   else
   if(what==3) { r=r*mul; g=g*mul; }    else
   if(what==4) { g=g*mul; b=b*mul; }    else
   if(what==5) { b=b*mul; r=r*mul;}
   capframe.data[i*4+0]=r;
   capframe.data[i*4+1]=g;
   capframe.data[i*4+2]=b;
   capframe.data[i*4+3]=a;
   }
  }
 return;
 }






 function mediaFrameProcess (cgrp,cw,ch,vgrp,vw,vh)
 {
 var capframe,xdif,j,z,cc;
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 xdif=Math.floor((vw-cw)/2);

 ///
 //console.log(vgrp.obj.id);
 //console.log(cgrp.obj.id);
 aa.guiCanvasImageDraw(cgrp.obj.han,0,0,cw,ch,0,0,vw,vh,vgrp.obj.dom);

 if(app.options.fx_censor==true||app.options.fx_darken==true||app.options.fx_brighten==true||app.options.fx_disco==true)
  {
  if(cw>ch) { cc=cw; } else { cc=ch; }
  capframe=aa.guiCanvasImageGet(cgrp.obj.han,0,0,cc,cc);
  if(app.options.fx_censor==true)   { mediaFxCensor(capframe.width,capframe.height,12,capframe); }
  if(app.options.fx_darken==true)   { mediaFxBrighten(capframe.width,capframe.height,0.5,capframe); }
  if(app.options.fx_brighten==true) { mediaFxBrighten(capframe.width,capframe.height,1.5,capframe); }
  if(app.options.fx_disco==true)    { mediaFxFlashing(capframe.width,capframe.height,aa.numRand(6),aa.numRand(4),capframe); }
  aa.guiCanvasImagePut(cgrp.obj.han,0,0,0,0,cc,cc,capframe);

  }

 //  mediaFxBrighten(capframe.width,capframe.height,2,capframe);
//   aa.guiCanvasImagePut(cgrp.obj.han,0,0,0,0,cw,ch,capframe);


 if(app.options.aud_act==true)
  {
  //guixLenseHudLog(app.guix.lense,cw+" "+ch+"  "+vw+" "+vh);
  mediaVideoAddVadColor(cgrp,vw,vh);
  }
 }





 function mediaVideoAddVadColor (cgrp,cw,ch)
 {
 var txt,ypos,fnt,yadd;
 if(1&&aa_profiler.is_started&&cfg_profiler_media_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 if(app.media.aud_pro==undefined) { return; }
 ///guixHudLog(0,app.media.aud_pro.analyser_level+"  "+app.media.cur_local_mute);
  //guixLenseHudLog(app.guix.lense,app.media.aud_pro.analyser_level+"  "+app.media.cur_local_mute+"  "+app.media.cur_local_gain+" "+cfg_audio_threshold);
 if(app.media.aud_pro.analyser_level>=cfg_audio_threshold&&app.media.cur_local_mute==false)
  {
  //guixLenseHudLog(app.guix.lense,cw+" "+ch);

  aa.guiCanvasBorder(cgrp.obj.han,1,1,cw-2,ch-2,2,aa.guiRgbaString(200,200,aa.numRand(255),1));
  aa.guiCanvasBorder(cgrp.obj.han,3,3,cw-6,ch-6,2,aa.guiRgbaString(200,20,aa.numRand(255),1));
  //aa.guiCanvasBorder(cgrp.obj.han,8,8,cw-16,ch-16,4,aa.guiRgbaString(200,20,aa.numRand(255),1));
  }
 }

//-----------------------------------------------------------------------






 function beamStart ()
 {
 app.beam={};
 app.beam.is_started=true;
 app.beam.b_canstream_0=aa.guiGroupGetById("b_canstream_0");
 app.beam.b_video_0=aa.guiGroupGetById("b_video_0");
 //app.beam.b_video_0=aa.guiGroupGetById("b_vippy_0");
 app.beam.b_video_1=aa.guiGroupGetById("b_video_1");
 app.beam.b_video_2=aa.guiGroupGetById("b_video_2");
 app.beam.b_video_3=aa.guiGroupGetById("b_video_3");
 }



 function beamNew (purpose,maxpeers,nick,room,url)
 {
 var beamobj,p;
 beamobj={};
 beamobj.type="beamobj";
 beamobj.purpose=purpose;
 beamobj.max_peers=maxpeers;
 beamobj.room=room;
 beamobj.nick=nick;
 beamobj.url=url;
 beamobj.stage=100;
 beamobj.is_ready=false;
 beamobj.is_full=false;
 beamobj.ms=aa_ms_running;
 beamobj.elapsed=0;
 beamobj.my_id=0;
 beamobj.my_alias="";
 beamobj.peer_count=0;
 beamobj.peer_count_connected=0;
 beamobj.peer_array=[];
 beamobj.peer_pf=0;
 beamobj.sock_handle=0;
 for(p=0;p<beamobj.max_peers;p++)  {  beamPeerInit(beamobj,p);  }
 beamobj.sock_handle=aa.socketCreate(beamobj.url);
 beamobj.sock_status=aa.socketStatus(beamobj.sock_handle);
 beamobj.prom=null;
 beamobj.ive_said_something=false;
 return beamobj;
 }






 function beamDelete (beamobj)
 {
 var p,peerobj,grpc;
 if(beamobj==undefined)      { return null; }
 if(beamobj.type!="beamobj") { return null; }
 for(p=0;p<beamobj.max_peers;p++)
  {
  peerobj=beamPeerByIndex(beamobj,p);
  if(peerobj.in_use!=true) { continue; }
  console.log(p+"/"+beamobj.max_peers+" inuse="+peerobj.in_use+" id="+peerobj.id+" dif="+peerobj.id_dif);
  if(peerobj.id_dif!=0)    { beamPeerUnuse(beamobj,peerobj.self_index);      }
  }
 grpc=app.beam["b_canstream_0"];
 if(grpc!=null)
  {
  if(grpc.vars.rtc_handle!==undefined&&grpc.vars.rtc_handle!=0)
   {
   console.log("is "+grpc.vars.rtc_handle);
   aa.rtcDestroy(grpc.vars.rtc_handle);
   grpc.vars.rtc_handle=0;
   }
  }
 aa.socketDestroy(beamobj.sock_handle);
 beamobj.sock_handle=0;
 beamobj.peer_array=[];
 beamobj={};
 return beamobj;
 }






 function beamCountSet (beamobj,peercount,peerconnectedcount)
 {
 beamobj.peer_count=peercount;
 beamobj.peer_count_connected=peerconnectedcount;
 }




 function beamPeerInit (beamobj,peerindex)
 {
 var peerobj,s;
 peerobj={};
 peerobj.in_use=false;
 peerobj.type="peerobj";
 peerobj.self_index=peerindex;
 peerobj.phaze=0;
 peerobj.sent_final_ice=false
 peerobj.rvcd_final_ice=false;
 peerobj.rtc_handle=0;
 peerobj.r_queue_handle=0;
 peerobj.r_queue_status=null;
 peerobj.ms=0;
 peerobj.cycle=0;
 peerobj.tally=null;//{};

 peerobj.id=0;
 peerobj.alias=null;
 peerobj.id_dif=null;
 beamobj.peer_array[peerindex]=peerobj;
 return peerobj;
 }





 function beamPeerNext (beamobj)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_beam_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var p,peerobj;
 if(beamobj.peer_count==0) { return null; }
 for(p=0;p<beamobj.max_peers;p++)
  {
  beamobj.peer_pf++;
  beamobj.peer_pf%=beamobj.max_peers;
  peerobj=beamobj.peer_array[beamobj.peer_pf];
  if(1)
   {
   if(peerobj==null)        { continue; }
   if(peerobj.in_use!=true) { continue; }
   }
  else
   {
   if(peerobj==null)        { break; }
   if(peerobj.in_use!=true) { break; }
   }
  return peerobj;
  }
 return null;
 }






 function beamPeerUnusedGet (beamobj)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_beam_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var p,peerobj;
 for(p=0;p<beamobj.max_peers;p++)
  {
  peerobj=beamPeerByIndex(beamobj,p);
  if(peerobj.in_use!=false) { continue; }
  return peerobj;
  }
 return null;
 }





 function beamPeerUse (beamobj,peerindex,id,alias)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_beam_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var peerobj,s;
 if(peerindex<0||peerindex>=beamobj.peer_array.length)  {  throw("cunt");  }
 peerobj=beamobj.peer_array[peerindex];
 if(peerobj.in_use!=false)  {  throw("peerinuse");  }
 peerobj.in_use=true;
 peerobj.type="peerobj";
 peerobj.self_index=peerindex;
 peerobj.phaze=0;
 peerobj.sent_final_ice=false
 peerobj.rvcd_final_ice=false;
 peerobj.rtc_handle=0;
 peerobj.r_queue_handle=aa.queueCreate();
 peerobj.r_queue_status=aa.queueStatus(peerobj.r_queue_handle);
 peerobj.tally={};
 peerobj.tally.is_started=false;
 peerobj.ms=aa.timerMsRunning();
 peerobj.cycle=0;

 peerobj.id=id;
 peerobj.alias=alias;
 peerobj.id_dif=(peerobj.id+"").localeCompare(beamobj.my_id+""); //!!!!!!!!!
 beamCountSet(beamobj,beamobj.peer_count+1,beamobj.peer_count_connected);
 if(id!=beamobj.my_id)
  {
  ///console.log("peeruse "+id+" "+alias);
  }
 return peerobj;
 }





 function beamPeerUnuse (beamobj,peerindex)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_beam_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var peerobj,rtc,grp,isplaying,grpo,idx;
 if(peerindex<0||peerindex>=beamobj.peer_array.length)  {  throw("cunt");  }
 peerobj=beamobj.peer_array[peerindex];
 if(peerobj.in_use!=true)  {  throw("peernotinuse");  }
 if(peerobj.phaze==200||peerobj.phaze==2000)
  {
  beamCountSet(beamobj,beamobj.peer_count,beamobj.peer_count_connected-1);
  }
 if(peerobj.r_queue_handle!=0)
  {
  aa.queueDestroy(peerobj.r_queue_handle);
  peerobj.r_queue_handle=0;
  }
 peerobj.tally=null;
 beamPeerVideoUnattach(beamobj,peerobj);
 beamPeerInit(beamobj,peerindex);
 beamCountSet(beamobj,beamobj.peer_count-1,beamobj.peer_count_connected);
 return peerobj;
 }





 function beamPeerByIndex (beamobj,peerindex)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_beam_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var peerobj;
 if(peerindex>=beamobj.max_peers) { return null; }
 peerobj=beamobj.peer_array[peerindex];
 return peerobj;
 }



 function beamPeerById (beamobj,peerid)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_beam_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var p,peerobj;
 if(peerid<=0) { aa.debugAlert(); }
 for(p=0;p<beamobj.max_peers;p++)
  {
  peerobj=beamobj.peer_array[p];
  if(peerobj.in_use!=true) { continue; }
  if(peerobj.id!=peerid)   { continue; }
  return peerobj;
  }
 return null;
 }






 function beamPeerVideoAttach (beamobj,peerobj)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_beam_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var rtc,g,grp,grpo,grpc;
 if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
 g=peerobj.self_index;
 if(g==0) { aa.debugAlert(); }
 console.log("video attach peerobj "+peerobj.id+"  index="+peerobj.self_index);
 grp=app.beam["b_video_"+g];
 if(grp==null)               { aa.debugAlert(); }
 if(grp.obj.type!="video")   { aa.debugAlert(); }
 if(grp.dom.srcObject!=null) { aa.debugAlert(); }
 if(g==0)
  {
  aa.debugAlert();
  console.log("VIDEO ATTACH  to canstream "+g);
  grpc=app.beam["b_canstream_"+g];
  grpc.vars.rtc_handle=0;
  }
 if(g!=0)
  {
  grp.vars.rtc_handle=peerobj.rtc_handle;
  }
 grp.vars.peer_index=peerobj.self_index;
 rtc.gui_id=grp.obj.id;
 grp.dom.srcObject=rtc.rem_stream;
 if(cfg_audio_peer_initially_muted==true)  {  grp.dom.muted=true;  grp.dom.volume=0;  }
 else                                      {  grp.dom.muted=false;  grp.dom.volume=1;  }
 ////grp.vars.is_showing=true;
 grp.vars.rtc_handle=peerobj.rtc_handle;
 console.log("video attach peer index = "+peerobj.self_index+"  "+peerobj.rtc_handle+"  "+grp.obj.id);
 if(beamobj.prom!=null)
  {
  alert("aa prom not null "+beamobj.prom);
  console.log("!!!!!!! aa prom not null "+beamobj.prom);
  }
 console.log("beam videoAttach about to PLAY!!!!!!!!!!");
 console.log("pre prom="+beamobj.prom);
 beamobj.prom=grp.dom.play();
 console.log("post prom="+beamobj.prom);
 if(beamobj.prom!==undefined);
  {
  console.log("playi");
  beamobj.prom.then(()=>
   {
   console.log("beam PLAY ok!!!!!!!!!!!!!!!");
   //alert("beam PLAY ok!!!!!!!!!!!!!!!");
   beamobj.prom=null;
   })
  .catch(error=>
   {
   console.log("beam PLAY err!!!!!!!!!!!!!!",error);
   //alert("beam PLAY err!!!!!!!!!!!!!!",error);
   beamobj.prom=null;
   });
  }
 }






 function beamPeerVideoUnattach (beamobj,peerobj)
 {
 if(1&&aa_profiler.is_started&&cfg_profiler_beam_use) { aaProfilerHit(arguments.callee.name); aaProfilerHit(arguments.callee.name+"<-"+arguments.callee.caller.name);  }
 var rtc,isplaying,grp,grpo,idx,g,pid,grpc;
 pid=peerobj.id;
 console.log("peerVideoUnattach "+peerobj.id);
 if(peerobj.rtc_handle>0)
  {
  if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) aa.debugAlert();
  if(rtc.gui_id!=null)
   {
   grp=app.beam[rtc.gui_id];
   if(grp!=null)
    {
    console.log("CCC "+grp.obj.id+"  "+grp.vars.rtc_handle);
    isplaying=grp.dom.currentTime>0&&!grp.dom.paused&&!grp.dom.ended&&grp.dom.readyState>2;
    grp.vars.rtc_handle=0;
    if(isplaying) {       grp.dom.pause();    }
    grp.dom.currentTime=0;
    grp.dom.srcObject=null;
    idx=rtc.peer_index;
    //grpo=aa.guiGroupGet(aa.guiIdFind("b_overlay_"+idx));
    g=peerobj.self_index;
    if(g==0) { aa.debugAlert(); }
    console.log("video unattach self index="+g);
    grp=app.beam["b_video_"+g];
    grpc=app.beam["b_canstream_"+g];
    if(grpc!=null)
     {
     ///console.log("B_CANSTREAM_"+g+"  force grpc.vars.rtc_handle=0").
     grpc.vars.rtc_handle=0;
     }
    }
   rtc.gui_id=null;
   }
  ///console.log("video unattach "+pid+"  RTC DESTROY "+peerobj.rtc_handle);
  aa.rtcDestroy(peerobj.rtc_handle);
  peerobj.rtc_handle=0;
///  grp.vars.rtc_handle=0;
  }
 }





 function beamDump (beamobj)
 {
 var i,peerobj,txt,done;
 done=0;
 for(i=0;i<beamobj.max_peers;i++)
  {
  peerobj=beamPeerByIndex(beamobj,i)
  if(peerobj.in_use!=true) { continue; }
  txt="";
  txt+=i+"/"+beamobj.max_peers+"  ";
  txt+="id="+peerobj.id+"  ";
  txt+="dif="+peerobj.id_dif+"  ";
  txt+="phz="+peerobj.phaze+" ";
  if(done==0)
   {
   console.log("beamDump");
   }
  console.log(txt);
  done++;
  }
 }





 function beamWrite (beamobj,how,ref,tid,cmd,dostrfy,txt)
 {
 var pkt,msg,jsr;
 if(how!="say"&&how!="scream"&&how!="shout")  { return false; }
 msg={};
 msg.funcname=cmd;
 msg.txt=txt;
 jsr=JSON.stringify(msg);
 if(how=="say")  {  pkt={"cmd":how,"tid":tid,"ref":ref,"msg":jsr};  }
 else            {  pkt={"cmd":how,"ref":ref,"msg":jsr};  }
 aa.socketWrite(beamobj.sock_handle,JSON.stringify(pkt));
 //if(cmd==
 return true;
 }


 function beamRead (beamobj,id)
 {
 var status,peerobj,msg;
 peerobj=beamPeerById(beamobj,id);
 if(peerobj==null) { aa.debugAlert(); }
 peerobj.r_queue_status=aa.queueStatus(peerobj.r_queue_handle);
 if(peerobj.r_queue_status==null) aa.debugAlert("beamread2 "+id);
 if(peerobj.r_queue_status.msgs_queued==0) {  return null;  }
 if((msg=aa.queueRead(peerobj.r_queue_handle))==null) aa.debugAlert("beamread3");
 peerobj.r_queue_status=aa.queueStatus(peerobj.r_queue_handle);
 return msg;
 }





 function beamPeek (beamobj,id)
 {
 var status,peerobj,msg;
 peerobj=beamPeerById(beamobj,id);
 if(peerobj==null) { aa.debugAlert(); }
 peerobj.r_queue_status=aa.queueStatus(peerobj.r_queue_handle);
 if(peerobj.r_queue_status==null) aa.debugAlert("beampeek2 "+id);
 if(peerobj.r_queue_status.msgs_queued==0) {  return null;  }
 if((msg=aa.queuePeek(peerobj.r_queue_handle,0))==null) aa.debugAlert("wsds3dwe00");
 peerobj.r_queue_status=aa.queueStatus(peerobj.r_queue_handle);
 return msg;
 }


 function beamDiscard (beamobj,id)
 {
 var status,peerobj,msg;
 peerobj=beamPeerById(beamobj,id);
 if(peerobj==null) { aa.debugAlert(); }
 peerobj.r_queue_status=aa.queueStatus(peerobj.r_queue_handle);
 if(peerobj.r_queue_status==null) aa.debugAlert("wxwew00");
 if(peerobj.r_queue_status.msgs_queued==0) { return true;  }
 if((msg=aa.queueRead(peerobj.r_queue_handle))==null) aa.debugAlert("xwxwxwx00");
 peerobj.r_queue_status=aa.queueStatus(peerobj.r_queue_handle);
 return true;
 }





 function beamAnnounce (beamobj,txt)
 {
 beamWrite(beamobj,"shout","aakak",null,"announce",true,txt);
 }






 function beamWriteJoin (beamobj)
 {
 var pkt,str;
 ///str=JSON.stringify(app.ei);
 ///console.log(str.length);
 str="";
 pkt={"cmd":"join","room":beamobj.room,"alias":beamobj.nick,"fingerprint":app.ei.finger_print,"envinfo":str,"geoinfo":"","testcount":beamobj.max_peers};
 //console.log(JSON.stringify(pkt,0,2));
 aa.socketWrite(beamobj.sock_handle,JSON.stringify(pkt));
 //console.log("wrote join");
 }




 function beamReadHi (beamobj,pkt)
 {
 var jsn,p,peerobj,i;

 try      {  jsn=JSON.parse(pkt); }
 catch(e) {  aa.debugAlert(e);    }
 ///jsn=JSON.parse(pkt);
 beamobj.my_id=jsn.id;
 beamobj.my_alias=jsn.hancock;
 if(app.display_nick==null||app.display_nick=="")
  {
  ///app.display_nick="user-"+beamobj.my_id;
  //if(aa.stringIndexOf(true,beamobj.my_alias," ",0)==-1)      {      app.display_nick=beamobj.my_alias;      }
  }
 console.log("MY_ID="+beamobj.my_id+"  MY_ALIAS="+beamobj.my_alias);
 for(p=0;p<beamobj.max_peers;p++)
  {
  if((peerobj=beamPeerById(beamobj,jsn.id))!=null) { aa.debugAlert(); }
  peerobj=beamPeerUse(beamobj,p,jsn.id,jsn.hancock);
  break;
  }
// console.log(JSON.stringify(jsn,0,2));
 for(i=0;i<jsn.peerCount;i++)
  {
  if((peerobj=beamPeerById(beamobj,jsn.peerList[i].id))!=null) { continue; }
  if((peerobj=beamPeerUnusedGet(beamobj))==null)               { aa.debugAlert(); }
  p=peerobj.self_index;
  peerobj=beamPeerUse(beamobj,p,jsn.peerList[i].id,jsn.peerList[i].hancock);
  }
 if(beamobj.peer_count>beamobj.max_peers)  // test before join loop
  {
  beamobj.is_full=true;
  beamobj.stage=66;
  return false;
  }
 return true;
 }



 function beamReadJoined(beamobj,pkt)
 {
 var jsn,peerobj,p;
 try      {  jsn=JSON.parse(pkt); }
 catch(e) {  aa.debugAlert(e);    }
 ///jsn=JSON.parse(pkt);
 if((peerobj=beamPeerById(beamobj,jsn.id))!=null) { aa.debugAlert(); }
 if(jsn.id==beamobj.my_id) { aa.debugAlert(); }
 if((peerobj=beamPeerUnusedGet(beamobj))==null)     { return false; }//aa.debugAlert(); }
 p=peerobj.self_index;
 peerobj=beamPeerUse(beamobj,p,jsn.id,jsn.hancock);
 console.log(peerobj.id+" has joined");
 return true;
 }


 function beamReadLeft (beamobj,pkt)
 {
 var jsn,peerobj,p;
 try      {  jsn=JSON.parse(pkt); }
 catch(e) {  aa.debugAlert(e);    }
 ///jsn=JSON.parse(pkt);
 console.log(jsn);
 if(beamobj.stage==66) { return true; }
 if((peerobj=beamPeerById(beamobj,jsn.id))==null)
  {
  return true;
  //aa.debugAlert();
  }
 console.log(peerobj.id+" has left");
 beamPeerUnuse(beamobj,peerobj.self_index);
 return true;
 }






 function beamWaitOfferCreate (beamobj,peerobj)
 {
 var status,val,rtc;
 status=aa.rtcStatus(peerobj.rtc_handle);
 if(status.in_promise==true)
  {
  while(1)
   {
   val=false;
   if(status.promise_status.state==PROMISE_completed)  { val=status.promise_status.val;      }    else
   if(status.promise_status.state==PROMISE_rejected)   { val=null; }
   if(status.promise_status.state==PROMISE_completed||status.promise_status.state==PROMISE_rejected)
    {
    if(aa.rtcPromiseClear(peerobj.rtc_handle)!=true) { aa.debugAlert(); }
    }
   if(val===null)   { console.log("rejected phaze="+peerobj.phaze); break; }
   if(val===false)  { break; }
   break;
   }
  }
 status=aa.rtcStatus(peerobj.rtc_handle);
 if(status.in_promise==true) { return false; }
 if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
 if(rtc.offer==null) { return false; }
 return true;
 }






 function beamWaitDescLocalSet (beamobj,peerobj)
 {
 var status,val,rtc;
 status=aa.rtcStatus(peerobj.rtc_handle);
 if(status.in_promise==true)
  {
  while(1)
   {
   val=false;
   if(status.promise_status.state==PROMISE_completed)  { val=status.promise_status.val;      }    else
   if(status.promise_status.state==PROMISE_rejected)   { val=null; }
   if(status.promise_status.state==PROMISE_completed||status.promise_status.state==PROMISE_rejected)
    {
    if(aa.rtcPromiseClear(peerobj.rtc_handle)!=true) { aa.debugAlert(); }
    }
   if(val===null)   { console.log("rejected phaze="+peerobj.phaze); break; }
   if(val===false)  { break; }
   break;
   }
  }
 status=aa.rtcStatus(peerobj.rtc_handle);
 if(status.in_promise==true) { return false; }
 if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
 if(rtc.loc_desc==null) { return false; }
 return true;
 }







 function beamWaitDescRemoteSet (beamobj,peerobj)
 {
 var status,val,rtc;
 status=aa.rtcStatus(peerobj.rtc_handle);
 if(status.in_promise==true)
  {
  while(1)
   {
   val=false;
   if(status.promise_status.state==PROMISE_completed)  { val=status.promise_status.val;      }    else
   if(status.promise_status.state==PROMISE_rejected)   { val=null; }
   if(status.promise_status.state==PROMISE_completed||status.promise_status.state==PROMISE_rejected)
    {
    if(aa.rtcPromiseClear(peerobj.rtc_handle)!=true) { aa.debugAlert(); }
    }
   if(val===null)   { console.log("rejected phaze="+peerobj.phaze); break; }
   if(val===false)  { break; }
   break;
   }
  }
 status=aa.rtcStatus(peerobj.rtc_handle);
 if(status.in_promise==true) { return false; }
 if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
 if(rtc.rem_desc==null) { return false; }
 return true;
 }






 function beamWaitAnswerCreate (beamobj,peerobj)
 {
 var status,val,rtc;
 status=aa.rtcStatus(peerobj.rtc_handle);
 if(status.in_promise==true)
  {
  while(1)
   {
   val=false;
   if(status.promise_status.state==PROMISE_completed)  { val=status.promise_status.val;      }    else
   if(status.promise_status.state==PROMISE_rejected)   { val=null; }
   if(status.promise_status.state==PROMISE_completed||status.promise_status.state==PROMISE_rejected)
    {
    if(aa.rtcPromiseClear(peerobj.rtc_handle)!=true) { aa.debugAlert(); }
    }
   if(val===null)   { console.log("rejected phaze="+peerobj.phaze); break; }
   if(val===false)  { break; }
   break;
   }
  }
 status=aa.rtcStatus(peerobj.rtc_handle);
 if(status.in_promise==true) { return false; }
 if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
 if(rtc.answer==null) { return false; }
 return true;
 }






 function beamYield (beamobj)
 {
 var i;
 if(beamobj===undefined) { return; }
 for(i=0;i<4;i++)
  {
  beamYieldSub(beamobj);
  }
 }



 function beamYieldSub (beamobj)
 {
 var pkt,jsn,po,peerobj,msg,i;
 if(beamobj===undefined)       { return false; }
 if(beamobj.type==undefined)   { return false; }
 beamobj.sock_status=aa.socketStatus(beamobj.sock_handle);
 if((beamobj.sock_status.is_closed==true||beamobj.sock_status.is_error==true)&&(1))  {   return false;  }
 if(beamobj.sock_status.is_open!=true) { return false; }

 switch(beamobj.stage)
  {
  case 100:
  beamWriteJoin(beamobj);
  beamobj.stage=150;
  break;

  case 150:
  while(1)
   {
   if((pkt=aa.socketRead(beamobj.sock_handle))==null) { break; }
   try      {  jsn=JSON.parse(pkt); }
   catch(e) {  aa.debugAlert(e);    }

   switch(jsn.cmd)
    {
    default:
    aa.debugAlert(" unknown cmd="+jsn.cmd);
    break;

    case "hi":
    console.log("got hi!!!!!!!!!!");
    beamReadHi(beamobj,pkt);
    beamobj.is_ready=true;
    console.log("is ready");
    if(beamobj.stage==66) { break; }
    beamobj.stage=200;
    break;

    case "full":
    console.log("got full!!!!!!!!!!");
    console.log("FULLL");
    beamobj.is_full=true;
    beamobj.stage=66;
    break;
    }
   if(beamobj.stage!=150) { break; }
   }
  break;



  case 200:
  beamobj.elapsed=aa_ms_running-beamobj.ms;
  if((po=beamPeerNext(beamobj))!=null)
   {
   beamPeerYield(beamobj,po.self_index);
   }
  while(1)
   {
   beamobj.sock_status=aa.socketStatus(beamobj.sock_handle);
   if(beamobj.sock_status.rcve_queue_status.msgs_queued==0) { break; }
   //alert(beamobj.sock_status.buffered+"  "+beamobj.sock_status.rcve_queue_status.msgs_queued+"  "+beamobj.sock_status.rcve_queue_status.msgs_total);
   if((pkt=aa.socketRead(beamobj.sock_handle))==null) { break; }
   try      {  jsn=JSON.parse(pkt); }
   catch(e) {  aa.debugAlert(e);    }

   switch(jsn.cmd)
    {
    default:
    aa.debugAlert("unknown cmd="+jsn.cmd);
    break;

    case "joined":
    console.log("got joined!!!!!!!!!!");
    beamReadJoined(beamobj,pkt);
    break;

    case "left":
    console.log("got left!!!!!!!!!!");
    beamReadLeft(beamobj,pkt);
    break;

    case "screamed":
    case "shouted":
    case "said":
    try      {  msg=JSON.parse(jsn.msg); }
    catch(e) {  aa.debugAlert(e);    }
    if(jsn.to_id!=beamobj.my_id)  { aa.debugAlert("to is not me "+jsn.to_id);  break; }
    while(1)
     {
     if(msg.funcname=="ice")    { break; }
     if(msg.funcname=="offer")  { break; }
     if(msg.funcname=="answer") { break; }
     if(jsn.cmd=="shouted")
      {
      if(msg.funcname=="announce")
       {
       guixWidgetChatLogLog(app.guix.widget_chatlog,jsn.id,msg.txt);
       }
      }
     /**
     if(jsn.cmd=="shouted"&&msg.funcname=="announce")
      {
      switch(msg.txt)
       {
       case "nuka":
       if(jsn.id==beamobj.my_id) { aa.envReload(true,aa.numRandValue(200,400));    }
       break;
       case "nukb":
       if(jsn.id!=beamobj.my_id) { aa.envReload(true,aa.numRandValue(200,400));    }
       break;
       case "nukc":
       aa.envReload(true,aa.numRandValue(200,400));
       break;
       case "cca":
       if(jsn.id==beamobj.my_id) { i=(app.media.cur_vxi+1)%mediaDeviceCountGet("videoinput");  mediaCamSwap(i); }
       break;
       case "ccb":
       if(jsn.id!=beamobj.my_id) { i=(app.media.cur_vxi+1)%mediaDeviceCountGet("videoinput");  mediaCamSwap(i); }
       break;
       case "ccc":
       i=(app.media.cur_vxi+1)%mediaDeviceCountGet("videoinput");  mediaCamSwap(i);
       break;
       case "aca":
       if(jsn.id==beamobj.my_id) { i=(app.media.cur_axi+1)%mediaDeviceCountGet("audioinput");  mediaMicSwap(i); }
       break;
       case "acb":
       if(jsn.id!=beamobj.my_id) { i=(app.media.cur_axi+1)%mediaDeviceCountGet("audioinput");  mediaMicSwap(i); }
       break;
       case "acc":
       i=(app.media.cur_axi+1)%mediaDeviceCountGet("audioinput");  mediaMicSwap(i);
       break;
       case "oca":
       if(jsn.id==beamobj.my_id) {  i=(app.media.cur_axo+1)%mediaDeviceCountGet("audiooutput"); mediaChangeSinks(i); }
       break;
       case "ocb":
       if(jsn.id!=beamobj.my_id) {  i=(app.media.cur_axo+1)%mediaDeviceCountGet("audiooutput"); mediaChangeSinks(i); }
       break;
       case "occ":
       i=(app.media.cur_axo+1)%mediaDeviceCountGet("audiooutput"); mediaChangeSinks(i);
       break;
       case "mute":
       if(jsn.id==beamobj.my_id)
        {
        if(app.media.cur_local_mute==false)         {         app.media.cur_local_mute=true;         app.media.cur_local_gain=0.0;         }
        else                                        {         app.media.cur_local_mute=false;         app.media.cur_local_gain=4.5;        }
        }
       break;
       }
      }
     */
     break;
     }

    if((peerobj=beamPeerById(beamobj,jsn.id))==null) { aa.debugAlert("from isnt a peer "+jsn.id); break; }
    if(jsn.cmd=="screamed"||jsn.cmd=="shouted"||jsn.cmd=="said")
     {
     if(msg.funcname=="announce")
      {
      if(peerobj.cycle==0)
       {
       }
      }
     }
    aa.queueWrite(peerobj.r_queue_handle,jsn);
    peerobj.r_queue_status=aa.queueStatus(peerobj.r_queue_handle);
    break;
    }
   if(beamobj.stage!=200) { aa.debugAlert(beamobj.stage); break; }
   break;
   }
  }
 return true;
 }







 function beamPeerYield (beamobj,peerindex)
 {
 var peerobj,pkt,rtc,grp,msg,ice,xxx,val,status,ree,spl,i,str,ret,cob,txt,s,sts,coba,cobb,ela,dif,btr,secs;
 if(peerindex>=beamobj.max_peers) { return; }

 peerobj=beamobj.peer_array[peerindex];
 if(peerobj==null)        { return; }
 if(peerobj.in_use!=true) { return; }
 if(peerobj.is_leaving)     { aa.debugAlert();  return;  }
 if(beamobj.is_ready!=true) { aa.debugAlert(); }

 switch(peerobj.phaze)
  {
  case 0:
  peerobj.phaze=100;
  break;

  case 66:
  case 666:
  break;




                case 100: // creation of individual WebRtc connections
                if(peerobj.id_dif==0)
                 {
                 beamCountSet(beamobj,beamobj.peer_count,beamobj.peer_count_connected+1);
                 peerobj.phaze=200;
                 break;
                 }
                //peerobj.rtc_handle=aa.rtcCreate({'iceServers':[{'urls':'stun:stun.l.google.com:19302'}]});
                peerobj.rtc_handle=aa.rtcCreate({'iceServers':[{'urls':
                ['stun:stun.l.google.com:19302',
                 'stun:stun1.l.google.com:19302',
                 'stun:stun2.l.google.com:19302',
                 'stun:stun.l.google.com:19302?transport=udp']}]});
                if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
                rtc.vars.peer_index=peerobj.self_index;
                grp=app.beam["b_canstream_0"];
                if(grp==null) { aa.debugAlert(); }

                if(grp.vars.audio_processor.destination!=undefined)
                 {
                 rtc.pc.addTrack(grp.vars.audio_processor.destination.stream.getAudioTracks()[0] , grp.vars.audio_processor.stream);
                 }
                rtc.pc.addTrack(grp.vars.audio_processor.stream.getVideoTracks()[0] , grp.vars.audio_processor.stream);



                if(peerobj.id_dif>0)  {    peerobj.phaze=400; break;    }
                if(peerobj.id_dif<0)  {    peerobj.phaze=600; break;    }
                break;



        case 200: // Peer connection to self
        pkt=beamPeek(beamobj,peerobj.id);
        if(pkt==null||pkt==false) { break; }
        beamDiscard(beamobj,peerobj.id);
        break;


                case 400:
///                     console.log("DCDC="+aa.rtcDataChannelCreate(peerobj.rtc_handle,'datachan0',true,null,null));
///                     console.log("DCDC="+aa.rtcDataChannelCreate(peerobj.rtc_handle,'datachan1',true,null,null));
///                     console.log("DCDC="+aa.rtcDataChannelCreate(peerobj.rtc_handle,'datachan2',true,null,null));

                aa.rtcOfferCreate(peerobj.rtc_handle);
                peerobj.phaze=430;
                break;



                case 430:
                if(beamWaitOfferCreate(beamobj,peerobj)==false) { break;  }
                peerobj.phaze=435;
                break;


                case 435:
                status=aa.rtcStatus(peerobj.rtc_handle);
                if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
                if(cfg_sdp_manip==true)
                 {
                 rtc.offer.sdp=aa.mediaSdpManipulate(rtc.offer.sdp,cfg_sdp_sbool,cfg_sdp_max_arate,cfg_sdp_max_vrate);
                 }
                //if(1&&manip_sdp==true)  {  rtc.vars.offer.sdp=mediaSdpManipulate(rtc.vars.offer.sdp,sbool,arata,vrata);  }
                aa.rtcDescLocalSet(peerobj.rtc_handle,rtc.offer);
                peerobj.phaze=440;
                break;


                case 440:
                if(beamWaitDescLocalSet(beamobj,peerobj)==false) { break;  }
                peerobj.phaze=450;
                break;



                case 450:
                status=aa.rtcStatus(peerobj.rtc_handle);
                if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
                beamWrite(beamobj,"say","aakak",peerobj.id,"offer",true,rtc.offer);
                peerobj.phaze=460;
                break;



                case 460:
                pkt=beamPeek(beamobj,peerobj.id);
                if(pkt==null||pkt==false) { break; }
                try      {  msg=JSON.parse(pkt.msg); }
                catch(e) {  aa.debugAlert(e);    }
                if(msg.funcname!="answer")
                 {
                 aa.debugAlert(msg.funcname+"  "+msg.txt);
                 beamDiscard(beamobj,peerobj.id);
                 break;
                 }
                beamDiscard(beamobj,peerobj.id);
                if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
                rtc.answer=msg.txt;//JSON.parse(msg.txt).txt;
                peerobj.phaze=470;
                break;



                case 470:
                status=aa.rtcStatus(peerobj.rtc_handle);
                if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
                //console.log("about to set desc remote");
                aa.rtcDescRemoteSet(peerobj.rtc_handle,rtc.answer);
                peerobj.phaze=480;
                break;



                case 480:
                if(beamWaitDescRemoteSet(beamobj,peerobj)==false) { break;  }
                peerobj.phaze=900;
                break;




           case 600: // We are accepting from this peer
           if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
           pkt=beamPeek(beamobj,peerobj.id)
           if(pkt==null||pkt==false) { break; }
           try      {  msg=JSON.parse(pkt.msg); }
           catch(e) {  aa.debugAlert(e);    }
           if(msg.funcname!="offer")
            {
            aa.debugAlert(msg.funcname+"  "+msg.txt);
            beamDiscard(beamobj,peerobj.id);
            break;
            }
           beamDiscard(beamobj,peerobj.id);
           aa.rtcDescRemoteSet(peerobj.rtc_handle,msg.txt);
           peerobj.phaze=610;
           break;


           case 610:
           if(beamWaitDescRemoteSet(beamobj,peerobj)==false) { break;  }
           peerobj.phaze=620;
           break;



           case 620:
           aa.rtcAnswerCreate(peerobj.rtc_handle);
           peerobj.phaze=630;
           break;


           case 630:
           if(beamWaitAnswerCreate(beamobj,peerobj)===false) { break; }
           peerobj.phaze=645;
           break;



           case 645:
           if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
           if(cfg_sdp_manip==true)
            {
            rtc.answer.sdp=aa.mediaSdpManipulate(rtc.answer.sdp,cfg_sdp_sbool,cfg_sdp_max_arate,cfg_sdp_max_vrate);
            }
           aa.rtcDescLocalSet(peerobj.rtc_handle,rtc.answer);
           peerobj.phaze=647;
           break;



           case 647:
           if(beamWaitDescLocalSet(beamobj,peerobj)==false) { break;  }
           peerobj.phaze=720;
           break;



           case 720:
           if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
           beamWrite(beamobj,"say","aakak",peerobj.id,"answer",true,rtc.answer);
           peerobj.phaze=900;
           break;


           case 900:
           status=aa.rtcStatus(peerobj.rtc_handle);
           if(status.in_promise==true) {   aa.debugAlert(); }
           peerobj.phaze=1000;
           break;





                case 1000:  // icey
                if(beamobj.prom!=null)
                 {
                 ///alert("prom busy 1");
                 break;
                 }

                status=aa.rtcStatus(peerobj.rtc_handle);
                 if(status.in_promise==true)
                  {
                  alert("aaa peer obj phaze="+peerobj.phaze);
                  while(1)
                   {
                   val=false;
                   //aa.debugAlert(status.promise_status.state);
                   if(status.promise_status.state==PROMISE_completed)  { val=status.promise_status.val;      }    else
                   if(status.promise_status.state==PROMISE_rejected)   { aa.debugAlert(); val=null; }
                   if(status.promise_status.state==PROMISE_completed)
                    {
                    aa.debugAlert("prom fin "+status.promise_info+"  "+val);
                    ///console.log("prom fin "+status.promise_info);
                    }
                   if(status.promise_status.state==PROMISE_completed||status.promise_status.state==PROMISE_rejected)
                    {
                    alert("about to clear");
                    if(aa.rtcPromiseClear(peerobj.rtc_handle)!=true) { aa.debugAlert(); }
                    }
                   if(val===null)   { aa.debugAlert("rejected phaze="+peerobj.phaze); break; }
                   if(val===false)  { break; }
                   break;
                   }
                  break;
                  }



                while(1)
                 {
                 pkt=beamPeek(beamobj,peerobj.id)
                 if(pkt==null||pkt==false) { break; }
                 try      {  msg=JSON.parse(pkt.msg); }
                 catch(e) {  aa.debugAlert(e);    }
                 if(msg.funcname=="ice")
                  {
                  if(msg.txt==".")
                   {
                   peerobj.rvcd_final_ice=true;
                   if(aa.rtcIceCandidateAdd(peerobj.rtc_handle,".")!=true) { aa.debugAlert(); }
                   }
                  else
                   {
                   xxx={candidate:msg.txt};
                   if(0)
                    {
                    spl=xxx.candidate.candidate.split(" ");
                    str="";
                    for(i=4;i<spl.length;i++) { str+=spl[i]+" "; }
                    }
                   console.log(xxx);
                   if(aa.rtcIceCandidateAdd(peerobj.rtc_handle,xxx.candidate)!=true) { aa.debugAlert(); }
                   }
                  }
                 else
                  {
                  console.log(pkt);
                  console.log(msg);
                  console.log("xxxxxxxxxx "+msg.funcname+"   "+msg.txt);
                  }
                 beamDiscard(beamobj,peerobj.id);
                 break;
                 }

                if(beamobj.prom!=null)
                 {
                 ///alert("prom busy 2");
                 break;
                 }
                status=aa.rtcStatus(peerobj.rtc_handle);
                if(status.in_promise==true)
                 {
                 peerobj.phaze=1010;
                 break;
                 }

                if(peerobj.sent_final_ice==false)
                 {
                 if((ice=aa.rtcIceCandidateGet(peerobj.rtc_handle))!=null)
                  {
                  if(ice==".")
                   {
                   peerobj.sent_final_ice=true;
                   }
                  console.log("send");
                  console.log(ice);
                  beamWrite(beamobj,"say","aakak",peerobj.id,"ice",true,ice);
                  status=aa.rtcStatus(peerobj.rtc_handle);
                  if(status.in_promise==true) {      peerobj.phaze=1010;   break; }
                  break;
                  }
                 }

                if(peerobj.phaze!=1000)
                 {
                 alert("phaze not 1000 = "+peerobj.phaze);
                 break;
                 }

                if(peerobj.sent_final_ice!=true) { break; }
                if(peerobj.rvcd_final_ice!=true) { break; }
                peerobj.phaze=1200;
                break;


                 case 1010:
                 if(beamobj.prom!=null)
                  {
                  //alert("prom busy 3");
                  break;
                  }
                 status=aa.rtcStatus(peerobj.rtc_handle);
                 if(status.in_promise==true)
                  {
                  while(1)
                   {
                   val=false;
                   //aa.debugAlert(status.promise_status.state);
                   if(status.promise_status.state==PROMISE_completed)  { val=status.promise_status.val;      }    else
                   if(status.promise_status.state==PROMISE_rejected)   { aa.debugAlert(); val=null; }
                   if(status.promise_status.state==PROMISE_completed)
                    {
                    //aa.debugAlert("prom fin "+status.promise_info+"  "+val);
                    ///console.log("prom fin "+status.promise_info);
                    }
                   if(status.promise_status.state==PROMISE_completed||status.promise_status.state==PROMISE_rejected)
                    {
                   // aa.debugAlert("about to clear");
                    if(aa.rtcPromiseClear(peerobj.rtc_handle)!=true) { aa.debugAlert(); }
                    }
                   if(val===null)   { aa.debugAlert("rejected phaze="+peerobj.phaze); break; }
                   if(val===false)  { break; }
                   break;
                   }
                  break;
                  }
                status=aa.rtcStatus(peerobj.rtc_handle);
                if(status.in_promise==true) { break; }
                peerobj.phaze=1000;
                break;



                case 1200: // wait for remote stream
                if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
                status=aa.rtcStatus(peerobj.rtc_handle);
                if(rtc.gui_id==null&&rtc.rem_stream!=null)  {     peerobj.phaze=1300;        break;                 }
                if(rtc.gui_id!=null) { console.log("guiid !=null = "+rtc.gui_id);  break;     }
                break;




                            case 1300: // attach to unused video element
                            if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
                            if(beamobj.prom!=null)
                             {
                             //alert("prom busy 4");
                             break;
                             }
                            beamPeerVideoAttach(beamobj,peerobj);
                            console.log("video attach self index="+peerobj.self_index);
                            grp=app.beam["b_video_"+peerobj.self_index];
                            console.log("attach to "+grp.obj.id);
                            console.log("v wh="+grp.dom.videoWidth+"  "+grp.dom.videoHeight);
                            console.log("wh="+grp.dom.width+"  "+grp.dom.height);
                            //alert("about to sink 1300");
                            if(app.media.active_devenu.aud_output_list.length>app.media.cur_axo)
                             {
                             if(typeof grp.dom.setSinkId==="function")
                              {
                              grp.dom.setSinkId(app.media.active_devenu.aud_output_list[app.media.cur_axo].deviceId);
                              }
                             }
                            beamCountSet(beamobj,beamobj.peer_count,beamobj.peer_count_connected+1);

                            if(cfg_sdp_change_bitrate==false)              { peerobj.phaze=1900; break;   }
                            if(cfg_sdp_use_arate<=0&&cfg_sdp_use_vrate<=0) { peerobj.phaze=1900; break;   }
                            peerobj.phaze=1500;
                            break;


                     case 1500: // bitrates
                     if(cfg_sdp_use_arate<=0) { peerobj.phaze=1600; break; }
                     if(aa.rtcBitrateChange(peerobj.rtc_handle,cfg_sdp_use_arate,0)!=true) { aa.debugAlert(); }
                     peerobj.phaze=1520;
                     break;

                     case 1520:
                     if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
                     if(rtc.prom!==null) { break; }
                     peerobj.phaze=1600;
                     break;

                     case 1600: // bitrates
                     if(cfg_sdp_use_vrate<=0) { peerobj.phaze=1900; break; }
                     if(aa.rtcBitrateChange(peerobj.rtc_handle,0,cfg_sdp_use_vrate)!=true) { aa.debugAlert(); }
                     peerobj.phaze=1620;
                     break;

                     case 1620:
                     if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
                     if(rtc.prom!==null) { break; }
                     peerobj.phaze=1900;
                     break;




                     case 1900:
                     if((ret=aa.rtcStatsGet(peerobj.rtc_handle,450))!=true) { aa.debugAlert("a "+ret); break; }
                     peerobj.phaze=2000;
                     break;



                     case 2000:  // established
                     status=aa.rtcStatus(peerobj.rtc_handle);
                     if(status.in_promise==true) { aa.debugAlert(); break; }
                     if(status.prom!=null&&status.prom!=undefined) { console.log("in prom "+status.prom);  break; }
                     if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
                     while(1)
                      {
                      pkt=beamPeek(beamobj,peerobj.id)
                      if(pkt==null||pkt==false) { break; }
                      try      {  msg=JSON.parse(pkt.msg); }
                      catch(e) {  aa.debugAlert(e);    }
                      beamDiscard(beamobj,peerobj.id);
                      status=aa.rtcStatus(peerobj.rtc_handle);
                      }


                      if(rtcTally(beamobj,peerindex)==true) { rtcTallyDump(beamobj,peerindex); }
                      peerobj.cycle++;
                      if(beamobj.ive_said_something==false&&peerobj.cycle>200&&(aa.numRand(200)==0))//==400)
                       {
                       ///if(1)//app.options.auto_hello==true)
                       if(app.options.auto_hello==true)
                        {
                        beamAnnounce(beamobj,"has joined");
                        }
                       ///guixWidgetChatLogLog(app.guix.widget_chatlog,beamobj.my_id,"howdy");//jsn.id,msg.txt);
                       //console.log("i said hello");
                       //beamAnnounce(beamobj,"hello");
                       beamobj.ive_said_something=true;
                       }

                       ///if(aa.rtcDataChannelGet(peerobj.rtc_handle,0)!==false)    {               }

                     break;
  }
 }





 function rtcTallyDump (beamobj,peerindex)
 {
 var peerobj,txt;
 peerobj=beamobj.peer_array[peerindex];
 if(peerobj.tally.is_started!=true) { return false; }
 txt="";
 txt+="si="+peerobj.self_index+" ";
 txt+="ai="+peerobj.tally.audio_inbound_bps+" ";
 txt+="vi="+peerobj.tally.video_inbound_bps+" ";
 txt+="ao="+peerobj.tally.audio_outbound_bps+" ";
 txt+="vo="+peerobj.tally.video_outbound_bps+" ";

 txt+="ail="+peerobj.tally.audio_inbound_level+" ";
 txt+="mal="+app.media.aud_pro.analyser_level+" ";
 ///txt+="  "+peerobj.tally.audio_inbound_level+" ";
 //txt+="aie="+peerobj.tally.audio_inbound_energy+"  ";

 //console.log(txt);
/// guixLenseHudLog(app.guix.lense,txt);
 //guixHudLog
 return true;
 }





 function rtcTally (beamobj,peerindex)
 {
 var peerobj,rtc,s,coba,cobb,ela,dif,secs,btr,dodisc,ok;
 peerobj=beamobj.peer_array[peerindex];
 if((rtc=aa.rtcGet(peerobj.rtc_handle))==null) { aa.debugAlert("rtcget"); }
 if(peerobj.tally.is_started==false)
  {
  ///peerobj.tally.audio_inbound_energy=0;
  peerobj.tally.is_started=true;
  peerobj.tally.audio_inbound_level=0;

  peerobj.tally.audio_inbound_bps=0;
  peerobj.tally.video_inbound_bps=0;
  peerobj.tally.audio_outbound_bps=0;
  peerobj.tally.video_outbound_bps=0;

  //peerobj.tally.audio_inbound_pkts_lost=0;
  //peerobj.tally.video_inbound_pkts_lost=0;

  console.log(peerindex+" tally started");
  //peerobj.tally.
  }
 ok=false;
 for(s=0;s<16;s++)
  {
  if((coba=aa.rtcStatsPeek(peerobj.rtc_handle,s,0))!=null)
   {
   if((cobb=aa.rtcStatsPeek(peerobj.rtc_handle,s,1))!=null)
    {
    if(0) {console.log(coba.wkint+"   "+coba.fullname+"     "); console.log(JSON.stringify(coba.report,0,2));  }
    ela=cobb.ms-coba.ms;
    secs=ela/1000;
    dodisc=false;
    switch(coba.wkint)
     {
     case 1: // inbound-rtp-audio
     if(0) {console.log(coba.wkint+"   "+coba.fullname+"     "); console.log(JSON.stringify(coba.report,0,2));  }
     if(!isNaN(cobb.report.bytesReceived)&&!isNaN(coba.report.bytesReceived))
      {
      dif=cobb.report.bytesReceived-coba.report.bytesReceived;
      btr=(dif/secs)>>0;
      peerobj.tally.audio_inbound_bps=btr;
      dodisc=true;
      }
     ///console.log(coba.wkint+"  "+cobb.report.packetsLost);
     break;

     case 2: // inbound-rtp-video
     if(!isNaN(cobb.report.bytesReceived)&&!isNaN(coba.report.bytesReceived))
      {
      dif=cobb.report.bytesReceived-coba.report.bytesReceived;
      btr=(dif/secs)>>0;
      peerobj.tally.video_inbound_bps=btr;
      dodisc=true;
      }
     ///console.log(coba.wkint+"  "+cobb.report.packetsLost);
     break;

     case 3: // outbound-rtp-audio
     if(!isNaN(cobb.report.bytesSent)&&!isNaN(coba.report.bytesSent))
      {
      dif=cobb.report.bytesSent-coba.report.bytesSent;
      btr=(dif/secs)>>0;
      peerobj.tally.audio_outbound_bps=btr;
      dodisc=true;
      }
     break;

     case 4: // outbound-rtp-video
     if(!isNaN(cobb.report.bytesSent)&&!isNaN(coba.report.bytesSent))
      {
      dif=cobb.report.bytesSent-coba.report.bytesSent;
      btr=(dif/secs)>>0;
      peerobj.tally.video_outbound_bps=btr;
      dodisc=true;
      }
     break;

     case 9:
     if(0) {console.log(coba.wkint+"   "+coba.fullname+"     "); console.log(JSON.stringify(coba.report,0,2));  }
     if(!isNaN(cobb.report.audioLevel)&&!isNaN(coba.report.audioLevel))
      {
      //dif=cobb.report.audioLevel-coba.report.audioLevel;
      dif=cobb.report.audioLevel;
      dif=dif.toFixed(3);
      peerobj.tally.audio_inbound_level=dif;
      dodisc=true;
      }
     //dodisc=true;
     break;


     default:
     ///console.log(coba.wkint+"   "+coba.fullname+"     ");
     if(0) {console.log(coba.wkint+"   "+coba.fullname+"     "); console.log(JSON.stringify(coba.report,0,2));  }
     //dodisc=true;
     break;
     }

    if(dodisc==true)
     {
     if(aa.rtcStatsDiscard(peerobj.rtc_handle,s)!=true) { aa.debugAlert(); }
     ok=true;
     }
    }
   }
  }
 return ok;
 }




</script>
</html>
