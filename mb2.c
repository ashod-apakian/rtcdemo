/*-----------------------------------------------------------------------*/
 #include "mb2.h"
/*-----------------------------------------------------------------------*/
 _mb     mb={.magic=0};
 _server the_server={.magic=0};
/// _ffmpegcroner ffmpegcroner={.magic=0 };
/*-----------------------------------------------------------------------*/




 B mbStart                             (V)
 {
 B ret;
 _size s1;
 _rect r1;
 B buf[_32K];
 H done,i;
 Q off;

 if(0)
 {
 off=0;
 //for(i=0;i<100;i++)
 i=0;
 while(1)
  {
  if(off>=(20LL*(Q)_1GIG)) { break; }
  ret=aaFileLoadToBuffer("d:\\github_two\\mdn\\australia-oceania-latest.osm",off,30000,buf,&done);
  buf[30000]=0;
  //aaLog(-555,"%s",buf);
  //off+=3000000LL;
  off+=30000;
  if((i%200)==0) {   aaDebugf("%I64d",(20LL*(Q)_1GIG)-off);}
  i++;
  }
 oof;
 return RET_YES;
 }

 aaMemoryFill(&mb,sizeof(_mb),0);
 mb.magic=aaHPP(mbStart);
 if((ret=aaTimeLocalGet(&mb.launch_time))!=YES) { oops; }
 if((ret=aaTimeToString(&mb.launch_time,mb.launch_text,0,0))!=YES) { oops; }
 if((ret=aaInfoGet(&mb.info,F32))!=YES) { oops; }
 if((ret=aaManufacturerGet(mb.manu))!=YES) { oops; }
 aaStringFindFirstIStrings(mb.manu,0,0,0,&mb.who_i_am,"$$sentinel$$","google compute","amazon","PRIME B250M-A Rev X.0x","thinkpad","gigabyte p15f","openstack","red hat kvm",0);
 if(mb.who_i_am==3)
  {
  if((ret=aaFileFolderCreate("uservids"))!=YES) { oops; }
  if((ret=aaFileFolderCreate("uservids\\v0"))!=YES) { oops; }
  if((ret=aaFileFolderCreate("uservids\\v0\\pool"))!=YES) { oops; }
  //if((ret=aaFileFolderCreate("uservids\\v0\\pool\\webm"))!=YES) { oops; }
  //if((ret=aaFileFolderCreate("uservids\\v0\\pool\\mp4"))!=YES) { oops; }
  if((ret=aaFileFolderCreate("uservids\\v0\\tree"))!=YES) { oops; }
  if((ret=aaFileFolderTreeCreate("uservids\\v0\\tree",2,1))!=YES) { oops; }
  if((ret=aaFileFolderTreeVerify("uservids\\v0\\tree",2,1))!=YES) { oops; }
  }
 aaFocusToDbg(0);
 aaDebugf(0);
 aaDebugfPrefix("mebeam");
 aaDebugfLogWriteSet(YES);
 aaDebugfLogStyleSet(2);
 aaDebugf("IAMb %i",mb.who_i_am);
 mb.tray_icon_index=0;
 mb.tray_icon_ms=aaMsRunning();
 aaSizeSet(&s1,80,80);
 if((ret=aaSurfaceCreate(&mb.surf.handle,&s1))!=YES) { oops; }
 if((ret=aaSurfaceVisualize(mb.surf.handle,YES-0,0))!=YES) { oops; }
 if((ret=aaSurfaceIconSetUsingResource(mb.surf.handle,1000,F32))!=YES) { oops; }
  aaSurfaceTitleSet(mb.surf.handle,"Mebeam");
 aaSurfaceStatus(mb.surf.handle,&mb.surf.status);
 if((ret=aaSurfaceTraySet(mb.surf.handle,1001+(mb.tray_icon_index%2),"%s %s.%s",mb.surf.status.title,MB_VERSION,DEV_VERSION))!=YES) { oops; }
 aaSurfaceStatus(mb.surf.handle,&mb.surf.status);
 mb.canvas_update_ms=aaMsRunning();
 aaSizeSet(&s1,920,580);
 aaRectSet(&r1,mb.info.display_info.tray_rect.x-s1.w-4,mb.info.display_info.tray_rect.y-s1.h-4,s1.w,s1.h);
 if((ret=aaSurfaceCreate(&mb.canvas.handle,&s1))!=YES) { oops; }
 if((ret=aaSurfaceVisualize(mb.canvas.handle,YES-1,0))!=YES) { oops; }
 if((ret=aaSurfaceIconSetUsingResource(mb.canvas.handle,1000,F32))!=YES) { oops; }
  aaSurfaceTitleSet(mb.canvas.handle,"%s %s.%s",mb.surf.status.title,MB_VERSION,DEV_VERSION);
 aaSurfaceRectSet(mb.canvas.handle,&r1);
 aaSurfaceFillFrame(mb.canvas.handle,0,2,&col_gray[2],&col_gray[10]);
 aaSurfaceShow(mb.canvas.handle,YES);
 aaSurfaceStatus(mb.canvas.handle,&mb.canvas.status);
 if((ret=aaFontCreate(&mb.font[0].handle,"consolas",0,-16,140,0,0,6,0))!=YES) { oops; }
 aaFontStatus(mb.font[0].handle,&mb.font[0].status);
 aaJsonCreate(&mb.json.handle,NO);
 ///aaJsonCreate(&mb.jot.handle,NO);
 aaCustomLogSet(mbLog);
 mbLog("sstarted MeBeam %s @ %s (who_i_am=%i) dev=%s pid=%u",MB_VERSION,mb.manu,mb.who_i_am,DEV_VERSION,mb.info.sys_info.process_id);
 return RET_YES;
 }








 V mbStop                              (V)
 {
 if(mb.magic!=aaHPP(mbStart)) { return; }
 if(mb.surf.handle)            {  aaSurfaceDestroy(mb.surf.handle);  }
 if(mb.canvas.handle)          {  aaSurfaceDestroy(mb.canvas.handle);  }
 if(mb.json.handle)            {  aaJsonDestroy(mb.json.handle); }
 ///if(mb.jot.handle)            {  aaJsonDestroy(mb.jot.handle); }
 if(mb.font[0].handle)         {  aaFontDestroy(mb.font[0].handle); mb.font[0].handle=0; }
 if(mb.who_i_am==I_AM_DESKTOP) {  aaFocusToCodeBlocks(); }
 mbLog(" ");
 mbLog(" ");
 mbLog("stopped MeBeam %s.%s",MB_VERSION,DEV_VERSION);
 aaMemoryFill(&mb,sizeof(_mb),0);
 }








 B mbBillboard                         (VP fmt,...)
 {
 H i,j;
 if(mb.magic!=aaHPP(mbStart)) { return RET_NOTINITIALIZED; }
 aaVargsf128K(fmt);
 //aaLog(-555,"%-8.3f %s",aaSecsRunning(),str128k.buf);
 i=aaElementCount(mb.billboard)-1;
 for(j=1;j<aaElementCount(mb.billboard);j++)
  {
  aaStringCopy(mb.billboard[j-1],mb.billboard[j]);
  }
 aaStringCopyf(mb.billboard[i],"%-8.3f %-6I64d %s",aaSecsRunning(),mb.billhits,str128k.buf);
 mb.billhits++;
 ///aaDebugf("bill");
 return RET_YES;
 }








 B mbStats                             (V)
 {
 _rect r1;
 _netstatus ns;
 Q i;
 B tok[_16K];
 B etc[_16K];
 B txt[_16K];
 Q msr;
 H shade_throb[4]={0,2,4,2};
 S H this_cycle=0;
 if(mb.magic!=aaHPP(mbStart)) { return RET_NOTINITIALIZED; }
 aaSurfaceStatus(mb.canvas.handle,&mb.canvas.status);
 aaSurfaceStatus(mb.surf.handle,&mb.surf.status);
 aaRectSet(&r1,0,0,mb.canvas.status.size.w,mb.canvas.status.size.h);
 aaRectExpand(&r1,-4,-4);
 aaNetStatus(&ns);
 aaStringCopyf(tok,"%s.%s ",MB_VERSION,DEV_VERSION);
 aaStringNull(etc);
 aaStringAppendf(etc,"%s started %s\n",mb.canvas.status.title,mb.launch_text);
 if(mb.is_uploading_upgrade)    {    aaStringAppendf(etc,"UPLOADING UPGRADE %.2f%%\n",mb.upload_complete);    }
 msr=aa_msrunning;
 if(msr<60000)     {     aaStringCopyf(txt,"secs=%.4f",msr/1000.0);    }   else
 if(msr<3600000)   {     aaStringCopyf(txt,"mins=%.4f",msr/60000.0);   }   else
                   {     aaStringCopyf(txt,"hrs=%.4f",msr/3600000.0);  }
 aaStringAppendf(etc,"%-15s ",txt);
 aaStringAppendf(etc,"cycle=%-10I64d ",aa_cycle);
 aaStringAppendf(etc,"ver=%-9s stg=%i ",tok,aa_stage);
 aaStringAppendf(etc,"pid=%u",mb.info.sys_info.process_id);
 aaStringAppendf(etc,"\n");
 aaStringAppendf(etc,"TOT: ");
 aaStringAppendf(etc,"out_tcp_cc=%-4i ",ns.total_outgoing_tcp_call_count);
 aaStringAppendf(etc,"in_tcp_cc=%-5i ",ns.total_incoming_tcp_call_count);
 aaStringAppendf(etc,"tcp_cc=%-6i",ns.total_tcp_call_count);
 aaStringAppendf(etc,"\n");
 aaStringAppendf(etc,"CUR: ");
 aaStringAppendf(etc,"out_tcp_cc=%-4i ",ns.current_outgoing_tcp_call_count);
 aaStringAppendf(etc,"in_tcp_cc=%-5i ",ns.current_incoming_tcp_call_count);
 aaStringAppendf(etc,"tcp_cc=%-6i",ns.current_tcp_calls_connected);
 aaStringAppendf(etc,"\n");
 aaStringAppendf(etc,"CUR: ");
 aaStringAppendf(etc,"cpu_load=%-6.2f ",aa_curcpuload);
 aaStringAppendf(etc,"pro_load=%-6.2f",aa_curproload);
 aaStringAppendf(etc,"\n");
 aaStringAppendf(etc,"AVG: ");
 aaStringAppendf(etc,"cpu_load=%-6.2f ",aa_avgcpuload);
 aaStringAppendf(etc,"pro_load=%-6.2f",aa_avgproload);
 aaStringAppendf(etc,"\n");
 aaStringAppendf(etc,"YLD: ");
 aaStringAppendf(etc,"ask_herz=%-6.1f ",aa_askhz);
 aaStringAppendf(etc,"cur_herz=%-6.1f ",aa_curhz);
 aaStringAppendf(etc,"eve_wai=%i",aa_ie_events_waiting);
 aaStringAppendf(etc,"\n");
 for(i=0;i<aaElementCount(mb.billboard);i++)  {  aaStringAppendf(etc,"%s\n",mb.billboard[i]);  }
 if(mb.is_uploading_upgrade)    {    aaSurfaceLabel(mb.canvas.handle,&r1,&col_pastelblue[24],mb.font[0].handle,&col_gray[2],4,4,0,0,0,"%s",etc);    }
 //else                           {    aaSurfaceLabel(mb.canvas.handle,&r1,&col_gray[24+aaMathRand32(0,3)],mb.font[0].handle,&col_gray[2],4,4,0,0,0,"%s",etc);    }
 else                           {    aaSurfaceLabel(mb.canvas.handle,&r1,&col_gray[(31-(aaElementCount(shade_throb)*2))+shade_throb[this_cycle%aaElementCount(shade_throb)]],mb.font[0].handle,&col_gray[2],4,4,0,0,0,"%s",etc);    }
 if(mb.canvas.status.is_shown)     {    aaSurfaceUpdateAreaAdd(mb.canvas.handle,0,YES);    }
 else                              {    aaSurfaceUpdateAreaAdd(mb.canvas.handle,0,NO);     }
 aaSurfaceStatus(mb.canvas.handle,&mb.canvas.status);
 this_cycle++;
 if((this_cycle%10)==0)
  {
  mbBillboard("time=%I64d",aa_cycle);
  }
 return RET_YES;
 }











 B mbYield                             (V)
 {
 B ret;
 B ir;
 Q el;
 _rect r1;
 _size s1;
 _inputstate is;
 if(mb.magic!=aaHPP(mbStart)) { return RET_NOTINITIALIZED; }
 if((ret=aaYield(2000))!=YES) { return ret; }
 aaSurfaceStatus(mb.canvas.handle,&mb.canvas.status);
 aaSurfaceStatus(mb.surf.handle,&mb.surf.status);
 if(aa_cycle==1500)
  {
  aaSurfaceShow(mb.canvas.handle,YES);
  aaSurfaceStatus(mb.canvas.handle,&mb.canvas.status);
  }
 if(mb.surf.status.is_systray)
  {
  el=aa_msrunning-mb.canvas_update_ms;
  if(el>=509)
   {
   mbStats();
   mb.canvas_update_ms=aa_msrunning;
   aaMsRunning();
   }
  el=aa_msrunning-mb.tray_icon_ms;
  if(el>=309)
   {
   if(aa_display_change_counter)
    {
    if((ret=aaInfoGet(&mb.info,F32))!=YES) { oops; }
    aaSizeSet(&s1,mb.canvas.status.size.w,mb.canvas.status.size.h);
    aaRectSet(&r1,mb.info.display_info.tray_rect.x-s1.w-4,mb.info.display_info.tray_rect.y-s1.h-4,s1.w,s1.h);
    aaSurfaceRectSet(mb.canvas.handle,&r1);
    aaSurfaceStatus(mb.canvas.handle,&mb.canvas.status);
    aa_display_change_counter=0;
    mbLog("display size = %ix%i",mb.info.display_info.screen_size.w,mb.info.display_info.screen_size.h);
    }
   mb.tray_icon_index++;
   if((ret=aaSurfaceTraySet(mb.surf.handle,1001+(mb.tray_icon_index%2),"%s %s.%s",mb.surf.status.title,MB_VERSION,DEV_VERSION))!=YES) { oops; }
   mb.tray_icon_ms=aa_msrunning;
   }
  if(aaSurfaceIsTrayClicked(mb.surf.handle,0,&ir)==RET_YES)
   {
   if(ir)
    {
    if(mb.do_quit==0) { mb.do_quit=1; }
    }
   else
    {
    if(mb.canvas.status.is_shown)    {     aaSurfaceShow(mb.canvas.handle,NO);     }
    else                             {     aaSurfaceShow(mb.canvas.handle,YES);    }
    aaSurfaceStatus(mb.canvas.handle,&mb.canvas.status);
    }
   if((ret=aaSurfaceTrayClickClear(mb.surf.handle))!=YES) { oops; }
   aaSurfaceStatus(mb.surf.handle,&mb.surf.status);
   }
  }
 if(AUTO_MINIMIZE!=0&&aa_cycle==AUTO_MINIMIZE&&mb.canvas.status.is_shown)
  {
  aaSurfaceShow(mb.canvas.handle,NO);
  aaSurfaceStatus(mb.canvas.handle,&mb.canvas.status);

  ///mouse_event(MOUSEEVENTF_WHEEL, 200,200, 1, 0);

  }
 if(aa_ie_events_waiting)
  {
  aaInputStateGet(&is);
  }
 return RET_YES;
 }







 B mbLog                               (VP fmt,...)
 {
 aaVargsf64K(fmt);
 if(mb.magic!=aaHPP(mbStart)) { return RET_NOTINITIALIZED; }
 #if 0
 mb.log_ms=aaMsRunning();
 aaDebugf("%-5I64d %s",mb.log_ms,str32k.buf);
 aaLog(-555,"%-5I64d %s",mb.log_ms,str32k.buf);
 #else
 aaDebugf("%s",str64k.buf);
 //aaLog(-555,"%s",str64k.buf);
 #endif
 mb.log_counter++;
 return RET_YES;
 }





/*-----------------------------------------------------------------------*/



 V aaMain                              (V)
 {
 B ret;
 N jbi;

 mbStart();
 aaDebugf("sizeof _servercalldata=%i",sizeof(_servercalldata));
 aaDebugf("who=%i",mb.who_i_am);
  aaDebugf("about to start server");
  if((ret=serverNew(&the_server,0,8080,1,CALL_HANDLE_SPACE,serverProc))!=YES) { oops; }
  aaDebugf("made server");
  while(mbYield()==YES)
   {
   if(mb.do_quit==1) { break; }
   serverYield(&the_server,50);
   switch(aa_stage)    {   case 0:    aaStageSet(10);    break;    }
   if(aa_stage==F32)   {   break; }
   }
  serverDelete(&the_server);
 mbStop();
 }




/*-----------------------------------------------------------------------*/





 B websocketPktDump                    (_tcpcallunit*call,B oc,B ff,H bytes,VP data)
 {
 B out[_32K];
 B txt[_32K];
 H done,todo;
 BP bp;

 mbLog("packet dump oc = 0x%02x ff=0x%02x bytes=%i",oc,ff,bytes); return RET_YES;
 aaNetTcpCallStatus(call->handle,&call->status);
 bp=(BP)data;
 aaStringNull(out);
 aaStringAppendf(out,"ff=%i ",ff);
 switch(oc)
  {
  default:                       aaStringAppendf(out,"oc=%02x ",oc);  break;
  case WEBSOCKET_OPCODE_TEXT:    aaStringAppendf(out,"oc=TXT ");  break;
  case WEBSOCKET_OPCODE_BINARY:  aaStringAppendf(out,"oc=BIN ");  break;
  case WEBSOCKET_OPCODE_CLOSE:   aaStringAppendf(out,"oc=CLS ");  break;
  case WEBSOCKET_OPCODE_PING:    aaStringAppendf(out,"oc=PIN ");  break;
  case WEBSOCKET_OPCODE_PONG:    aaStringAppendf(out,"oc=PON ");  break;
  }
 aaStringAppendf(out,"by=%-5i ",bytes);
 done=0;
 aaStringAppendf(out,"rm: %-23s ",call->status.remote_dot);
 if(bytes<=32)
  {
  aaStringDumpFormat(txt,bytes,bp);
  aaStringAppendf(out,"%s ",txt);
  bp[bytes]=NULL_CHAR;
  mbLog("%s (%s)",out,bp);
  return RET_YES;
  }
 while(1)
  {
  todo=bytes-done;
  if(todo==0) { break; }
  todo=aaNumRoof(todo,32);
  aaStringDumpFormat(txt,todo,&bp[done]);
  aaStringAppendf(out,"%s ",txt);
  mbLog("%s",out);
  done+=todo;
  aaStringNull(out);
  aaStringAppendChars(out,SPACE_CHAR,48,YES);
  }
 return RET_YES;
 }













 B websocketPinger                     (_tcpcallunit*call)
 {
 Q ms;
 _servercalldata*cd;
 B etc[_2K];

 if(call==NULL)      { return RET_MISSINGPARM; }
 if(call->handle==0) { return RET_FAILED; }
 cd=(_servercalldata*)call->status.extra_data;;
 if(cd==NULL)              { oof; }
 if(cd->wock.is_open!=YES) { return RET_NOTREADY; }
 ms=aaMsRunning();
 if((ms-cd->wock.ping_xmit_last_ms)>=PING_TIMEOUT)
  {
  etc[0]='a';
  etc[1]=NULL_CHAR;
  aaNetWebsocketWrite(&cd->wock,WEBSOCKET_OPCODE_PING,YES,2,etc);
  ///aaDebugf("sending ping, last xmit was = %I64d",(ms-cd->wock.ping_xmit_last_ms));
  cd->wock.ping_xmit_last_ms=aaMsRunning();
  }
 return RET_YES;
 }










 B websocketPonger                     (_tcpcallunit*call,H bytes,VP data)
 {
 B ret;
 _servercalldata*cd;

 if(call==NULL)      { return RET_MISSINGPARM; }
 if(call->handle==0) { return RET_FAILED; }
 cd=(_servercalldata*)call->status.extra_data;;
 if(cd==NULL)              { oof; }
 if(cd->wock.is_open!=YES) { return RET_NOTREADY; }
 if((ret=aaNetWebsocketWrite(&cd->wock,WEBSOCKET_OPCODE_PONG,YES,bytes,data))!=YES) { oops; }
 cd->wock.pong_xmit_last_ms=aaMsRunning();
 return RET_YES;
 }













 B websocketReader                     (_tcpcallunit*call,BP oc,BP ff,HP bytes,H maxbytes,VP data)
 {
 B ret;
 _servercalldata*cd;
 BP bp;

 if(call==NULL)      { return RET_MISSINGPARM; }
 if(call->handle==0) { return RET_FAILED; }
 if(oc==NULL)    { return RET_MISSINGPARM; }
 if(ff==NULL)    { return RET_MISSINGPARM; }
 if(bytes==NULL) { return RET_MISSINGPARM; }
 if(data==NULL)  { return RET_MISSINGPARM; }
 cd=(_servercalldata*)call->status.extra_data;;
 if(cd==NULL)              { oof; }
 if(cd->wock.is_open!=YES) { aaDebugf("%s wock.is_open=",__func__,cd->wock.is_open); return RET_NOTREADY; }
 if((ret=aaNetWebsocketRead(&cd->wock,oc,ff,bytes,maxbytes,data))==RET_NOTREADY)
  {
  //if(aaMathRand32(0,4000)==0)
   //{
   if(call->status.ms>(PING_TIMEOUT/4))
    {
    if(call->status.rcve_inactivity>(PING_TIMEOUT*2))
     {
     if(cd->do_close==0)
      {
      //aaDebugf("timeout");
      cd->do_close=1;
      }
     }
    }
   //}

  if(((call->status.rcve_bytes==0&&call->status.xmit_bytes==0)||(call->status.closed_ms>=aaSecs(3)))&&(call->status.is_closed))
   {
   if(cd->do_close==0)
    {
    cd->do_close=1;
    }
   }
  return ret;
  }
 if(ret!=RET_YES) { oops; }
 bp=(BP)data;
 bp[*bytes]=NULL_CHAR;
 return RET_YES;
 }



/*-----------------------------------------------------------------------*/






 B serverRoomSendFull                  (_server*server)
 {
 B ret;
 _servergather gather;
 _servercalldata*cd;

 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 cd=(_servercalldata*)server->cd;
 if((ret=serverRoomGather(server,&gather,cd->room_name))!=YES) { oops; }
 serverCmdGeneric(server,"full",cd->room_name,cd->id_buf,cd->hancock);
 serverCmdKeyVal(server,"xfwd","%s",cd->wock.x_forwarded_for);
 serverCmdKeyInt(server,"peerCount",(G)gather.count);
 serverCmdFinish(server);
 if((ret=aaNetWebsocketWrite(&cd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { }
 return RET_YES;
 }












 B serverRoomSendHi                    (_server*server)
 {
 B ret;
 H i;
 _servergather gather;
 _servercalldata*cd;
 _tcpcallunit tcall;
 _servercalldata*tcd;

 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 cd=(_servercalldata*)server->cd;
 if((ret=serverRoomGather(server,&gather,cd->room_name))!=YES) { oops; }
 serverCmdGeneric(server,"hi",cd->room_name,cd->id_buf,cd->hancock);
 serverCmdKeyVal(server,"xfwd","%s",cd->wock.x_forwarded_for);
 serverCmdKeyInt(server,"peerCount",(G)gather.count);
 serverCmdString(server,"peerList");
 serverCmdAppend(server,":");
 serverCmdAppend(server,"[");
 for(i=0;i<gather.count;i++)
  {
  tcall.handle=server->ch_array[gather.ch_array_index[i]];
  aaNetTcpCallStatus(tcall.handle,&tcall.status);
  tcd=(_servercalldata*)tcall.status.extra_data;
  serverCmdAppend(server,"{");
  serverCmdKeyVal(server,"id",tcd->id_buf);
  serverCmdKeyVal(server,"hancock",tcd->hancock);
  serverCmdEolFix(server);
  serverCmdAppend(server,"},");
  }
 serverCmdEolFix(server);
 serverCmdAppend(server,"]");
 serverCmdFinish(server);
 if((ret=aaNetWebsocketWrite(&cd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { }
 return RET_YES;
 }











 B serverRoomBroadcastUserJoined       (_server*server)
 {
 B ret;
 H j;
 _servergather gather;
 _servercalldata*cd;
 _tcpcallunit tcall;
 _servercalldata*tcd;

 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 cd=(_servercalldata*)server->cd;
 if((ret=serverRoomGather(server,&gather,cd->room_name))!=YES) { oops; }
 for(j=0;j<gather.count;j++)
  {
  tcall.handle=server->ch_array[gather.ch_array_index[j]];
  if(tcall.handle==0) { continue; }
  if(tcall.handle==server->call.handle) { continue; }
  aaNetTcpCallStatus(tcall.handle,&tcall.status);
  tcd=(_servercalldata*)tcall.status.extra_data;
  if(tcd->is_ws!=YES)           { continue; }
  if(tcd->wock.is_open!=YES)    { continue; }
  if(tcd->do_close)             { continue; }
  if(tcd->type!=CALL_TYPE_ROOMER) { oof; }
  if(aaStringICompare(tcd->room_name,cd->room_name,0)!=YES) { oof; }
  serverCmdGeneric(server,"joined",cd->room_name,cd->id_buf,cd->hancock);
  serverCmdFinish(server);
  if((ret=aaNetWebsocketWrite(&tcd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { continue; } // oops;}
  }
 return RET_YES;
 }












 B serverRoomBroadcastLeft             (_server*server)
 {
 B ret;
 H j;
 _servergather gather;
 _servercalldata*cd;
 _tcpcallunit tcall;
 _servercalldata*tcd;

 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 cd=(_servercalldata*)server->cd;
 if((ret=serverRoomGather(server,&gather,cd->room_name))!=YES) { oops; }
 for(j=0;j<gather.count;j++)
  {
  tcall.handle=server->ch_array[gather.ch_array_index[j]];
  if(tcall.handle==0) { continue; }
  if(tcall.handle==server->call.handle) { continue; }
  aaNetTcpCallStatus(tcall.handle,&tcall.status);
  tcd=(_servercalldata*)tcall.status.extra_data;
  if(tcd->is_ws!=YES)           { continue; }
  if(tcd->wock.is_open!=YES)    { continue; }
  if(tcd->do_close)             { continue; }
  if(tcd->type!=CALL_TYPE_ROOMER) { oof; }
  if(aaStringICompare(tcd->room_name,cd->room_name,0)!=YES) { oof; }
  serverCmdGeneric(server,"left",cd->room_name,cd->id_buf,cd->hancock);
  if(0) { aaDebugf("sending left %s,%s,%s to %s,%s",cd->room_name,cd->id_buf,cd->hancock,tcd->id_buf,tcd->hancock); }
  serverCmdFinish(server);
  if((ret=aaNetWebsocketWrite(&tcd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { continue; } //oops;}
  }
 return RET_YES;
 }












 B serverRoomRelayScream               (_server*server)
 {
 B ret;
 _servercalldata*cd;
 _servergather gather;
 _tcpcallunit tcall;
 _servercalldata*tcd;
 H i;
 Q now;
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 cd=(_servercalldata*)server->cd;
 if((ret=serverRoomGather(server,&gather,cd->room_name))!=YES) { oops; }
 if((ret=aaTimeUtcExGet(&now))!=YES) { oops; }
 for(i=0;i<gather.count;i++)
  {
  tcall.handle=server->ch_array[gather.ch_array_index[i]];
  aaNetTcpCallStatus(tcall.handle,&tcall.status);
  tcd=(_servercalldata*)tcall.status.extra_data;
  if(tcd->is_joined!=YES) { continue; }
  if(cd->id_num==tcd->id_num) { continue; }
  serverCmdBegins(server,"screamed");
  serverCmdKeyVal(server,"now","%I64d",now);
  serverCmdKeyVal(server,"room","%s",cd->room_name);
  serverCmdKeyVal(server,"id","%s",cd->id_buf);
  serverCmdKeyVal(server,"hancock","%s",cd->hancock);
  serverCmdKeyVal(server,"to_id","%s",tcd->id_buf);
  serverCmdKeyVal(server,"to_hancock","%s",tcd->hancock);
  serverCmdKeyVal(server,"ref","%s",mb.json_text[4]);
  serverCmdKeyVal(server,"msg","%s",mb.json_text[6]);
  serverCmdEolFix(server);
  serverCmdFinish(server);
  if((ret=aaNetWebsocketWrite(&tcd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { continue;  }// oops;}
  }
 return RET_YES;
 }











 B serverRoomRelayShout                (_server*server)
 {
 B ret;
 _servercalldata*cd;
 _servergather gather;
 _tcpcallunit tcall;
 _servercalldata*tcd;
 H i;
 Q now;
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 cd=(_servercalldata*)server->cd;
 if((ret=serverRoomGather(server,&gather,cd->room_name))!=YES) { oops; }
 if((ret=aaTimeUtcExGet(&now))!=YES) { oops; }
 for(i=0;i<gather.count;i++)
  {
  tcall.handle=server->ch_array[gather.ch_array_index[i]];
  aaNetTcpCallStatus(tcall.handle,&tcall.status);
  tcd=(_servercalldata*)tcall.status.extra_data;
  if(tcd->is_joined!=YES) { continue; }
  serverCmdBegins(server,"shouted");
  serverCmdKeyVal(server,"now","%I64d",now);
  serverCmdKeyVal(server,"room","%s",cd->room_name);
  serverCmdKeyVal(server,"id","%s",cd->id_buf);
  serverCmdKeyVal(server,"hancock","%s",cd->hancock);
  serverCmdKeyVal(server,"to_id","%s",tcd->id_buf);
  serverCmdKeyVal(server,"to_hancock","%s",tcd->hancock);
  serverCmdKeyVal(server,"ref","%s",mb.json_text[4]);
  serverCmdKeyVal(server,"msg","%s",mb.json_text[6]);
  serverCmdEolFix(server);
  serverCmdFinish(server);
  if((ret=aaNetWebsocketWrite(&tcd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { continue; } //oops;}
  }
 return RET_YES;
 }










 B serverRoomRelaySay                  (_server*server)
 {
 B ret;
 _servercalldata*cd;
 _servergather gather;
 _tcpcallunit tcall;
 _servercalldata*tcd;
 H i;
 Q now;
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 cd=(_servercalldata*)server->cd;
 if((ret=serverRoomGather(server,&gather,cd->room_name))!=YES) { oops; }
 if((ret=aaTimeUtcExGet(&now))!=YES) { oops; }
 for(i=0;i<gather.count;i++)
  {
  tcall.handle=server->ch_array[gather.ch_array_index[i]];
  aaNetTcpCallStatus(tcall.handle,&tcall.status);
  tcd=(_servercalldata*)tcall.status.extra_data;
  if(tcd->is_joined!=YES) { continue; }
  if(aaStringICompare(tcd->id_buf,mb.json_text[4],0)!=YES) { continue; }
  serverCmdBegins(server,"said");
  serverCmdKeyVal(server,"now","%I64d",now);
  serverCmdKeyVal(server,"room","%s",cd->room_name);
  serverCmdKeyVal(server,"id","%s",cd->id_buf);
  serverCmdKeyVal(server,"hancock","%s",cd->hancock);
  serverCmdKeyVal(server,"to_id","%s",tcd->id_buf);
  serverCmdKeyVal(server,"to_hancock","%s",tcd->hancock);
  serverCmdKeyVal(server,"ref","%s",mb.json_text[6]);
  serverCmdKeyVal(server,"msg","%s",mb.json_text[8]);
  serverCmdEolFix(server);
  serverCmdFinish(server);
  if((ret=aaNetWebsocketWrite(&tcd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES)   {   continue;   }
  }
 return RET_YES;
 }




/*-----------------------------------------------------------------------*/




 B jsonDescriber                       (H bytes,VP data,B show)
 {
 B ret;
 H i,mx,r;

 aaJsonReset(mb.json.handle,NO);
 aaJsonAppendBytes(mb.json.handle,bytes,data);
 while(1) { if((ret=aaJsonDecode(mb.json.handle))==RET_YES) { break; } if(ret!=RET_INUSE) { oops; break; } }
 aaJsonStatus(mb.json.handle,&mb.json.status);
 if(mb.json.status.decode_success!=YES) { oof; }
 mx=aaElementCount(mb.json_line);
 for(i=0;i<mx;i++) {  mb.json_line[i].type=0;  mb.json_text[i][0]=NULL_CHAR;  }
 if(mb.json.status.lines>mx) { return RET_NO; }
 for(i=0;i<mb.json.status.lines;i++) { if((ret=aaJsonParserLineGet(mb.json.handle,i,&mb.json_line[i],&mb.json_text[i][0]))!=YES) {oops; break; }  }
 //mbLog("----------------------------------------");
 if(show==NO) { return RET_YES; }

 if(show==2)
  {
  i=0;
  while(1)
   {
   r=mb.json.status.lines-i;
   if(r==0) { break; }
   mbLog("ajsoN[%-2i/%-2i]= type=%-2i len=%-4i [%s]",i,mb.json.status.lines,mb.json_line[i].type,mb.json_line[i].len,mb.json_text[i]);
   i+=1;
   }
  return RET_YES;
  }

 i=0;
 while(1)
  {
  r=mb.json.status.lines-i;
  if(r==0) { break; }
  if(r>=1)
   {
   if(mb.json_line[i+0].type==JSON_TYPE_OBJOPEN)    {    i+=1;    continue;    }
   if(mb.json_line[i+0].type==JSON_TYPE_OBJCLOSE)    {    i+=1;    continue;    }
   if(mb.json_line[i+0].type==JSON_TYPE_ARRAYOPEN)    {    i+=1;    continue;    }
   if(mb.json_line[i+0].type==JSON_TYPE_ARRAYCLOSE)    {    i+=1;    continue;    }
   }
  if(r>=2)
   {
   if(mb.json_line[i+0].type==JSON_TYPE_KEY&&mb.json_line[i+1].type==JSON_TYPE_STRING)
    {
    mbLog("bjsoN[%-2i/%-2i]= type=KS len=%-4i [%s='%s']",i,mb.json.status.lines,mb.json_line[i+0].len+mb.json_line[i+1].len,mb.json_text[i+0],mb.json_text[i+1]);
    i+=2;
    continue;
    }
   if(mb.json_line[i+0].type==JSON_TYPE_KEY&&mb.json_line[i+1].type==JSON_TYPE_INT)
    {
    mbLog("cjsoN[%-2i/%-2i]= type=KI len=%-4i [%s=%s]",i,mb.json.status.lines,mb.json_line[i+0].len+mb.json_line[i+1].len,mb.json_text[i+0],mb.json_text[i+1]);
    i+=2;
    continue;
    }
   if(mb.json_line[i+0].type==JSON_TYPE_KEY&&mb.json_line[i+1].type==JSON_TYPE_NULL)
    {
    mbLog("djsoN[%-2i/%-2i]= type=KI len=%-4i [%s=%s]",i,mb.json.status.lines,mb.json_line[i+0].len+mb.json_line[i+1].len,mb.json_text[i+0],mb.json_text[i+1]);
    i+=2;
    continue;
    }
   if(mb.json_line[i+0].type==JSON_TYPE_KEY&&(mb.json_line[i+1].type==JSON_TYPE_FALSE||mb.json_line[i+1].type==JSON_TYPE_TRUE))
    {
    if(mb.json_line[i+1].type==JSON_TYPE_FALSE) {     mbLog("ejsoN[%-2i/%-2i]= type=KF len=%-4i [%s=%s]",i+0,mb.json.status.lines,mb.json_line[i+0].len+mb.json_line[i+1].len,mb.json_text[i+0],mb.json_text[i+1]);    }
    else
    if(mb.json_line[i+1].type==JSON_TYPE_TRUE)  {     mbLog("fjsoN[%-2i/%-2i]= type=KT len=%-4i [%s=%s]",i+0,mb.json.status.lines,mb.json_line[i+0].len+mb.json_line[i+1].len,mb.json_text[i+0],mb.json_text[i+1]);     }
    i+=2;
    continue;
    }
   }
  mbLog("gjsoN[%-2i/%-2i]= type=%-2i len=%-4i [%s]",i,mb.json.status.lines,mb.json_line[i].type,mb.json_line[i].len,mb.json_text[i]);
  i+=1;
  continue;
  }
 return RET_YES;
 }






/*-----------------------------------------------------------------------*/


 B jsonDecode                          (H bytes,VP data)
 {
 B ret;
 H i,mx;

 aaJsonReset(mb.json.handle,NO);
 aaJsonAppendBytes(mb.json.handle,bytes,data);
 while(1) { if((ret=aaJsonDecode(mb.json.handle))==RET_YES) { break; } if(ret!=RET_INUSE) { oops; break; } }
 aaJsonStatus(mb.json.handle,&mb.json.status);
 if(mb.json.status.decode_success!=YES) { oof; }
 mx=aaElementCount(mb.json_line);
 for(i=0;i<mx;i++)  {  mb.json_line[i].type=0;  mb.json_text[i][0]=NULL_CHAR;  }
 if(mb.json.status.lines>mx) { aaDebugf("l>mx"); return RET_NO; }//oof; }
 for(i=0;i<mb.json.status.lines;i++)
  {
  if((ret=aaJsonParserLineGet(mb.json.handle,i,&mb.json_line[i],&mb.json_text[i][0]))!=YES) {oops; break; }
  }
 return RET_YES;
 }










 B jsonFind                            (H from,NP line,VP key)
 {
 H i,r;

 aaLog(-555,"%-8.3f entered %s #%i  from %i key %s",aaSecsRunning(),__func__,__LINE__,from,key);

 if(line) { *line=-1; }
 i=from;
 while(1)
  {
  if((r=mb.json.status.lines-i)==0) { break; }
  if(r>=1)
   {
   if(mb.json_line[i+0].type!=JSON_TYPE_KEY)           { i++; continue; }
   if(aaStringICompare(mb.json_text[i+0],key,0)!=YES)  { i++; continue; }
   if(line) { *line=(N)i; }
   aaLog(-555,"%-8.3f %s #%i found line=%i",aaSecsRunning(),__func__,__LINE__,i);
   return RET_YES;
   }
  i++;
  }
 aaLog(-555,"%-8.3f %s #%i not found",aaSecsRunning(),__func__,__LINE__);
 return RET_NOTFOUND;
 }










 B jsonDump                            (V)
 {
 H i,r,l;
 B text[_128K];

 i=0;
 while(1)
  {
  r=mb.json.status.lines-i;
  if(r==0) { break; }
  if(r>=2)
   {
   if(mb.json_line[i+0].type==JSON_TYPE_KEY&&mb.json_line[i+1].type==JSON_TYPE_STRING)
    {
    l=aaNumRoof(mb.json_line[i+1].len,_32K);
    aaStringNCopy(text,mb.json_text[i+1],l,YES);
    mbLog("hjsoN[%-2i/%-2i]= type=KS len=%-4i [%s='%s']",i+0,mb.json.status.lines,mb.json_line[i+0].len+mb.json_line[i+1].len,mb.json_text[i+0],text);//mb.json_text[i+1]);
    i+=2;
    continue;
    }
   if(mb.json_line[i+0].type==JSON_TYPE_KEY&&mb.json_line[i+1].type==JSON_TYPE_INT)
    {
    l=aaNumRoof(mb.json_line[i+1].len,_32K);
    aaStringNCopy(text,mb.json_text[i+1],l,YES);
    mbLog("ijsoN[%-2i/%-2i]= type=KI len=%-4i [%s=%s]",i+0,mb.json.status.lines,mb.json_line[i+0].len+mb.json_line[i+1].len,mb.json_text[i+0],text);//mb.json_text[i+1]);
    i+=2;
    continue;
    }
   if(mb.json_line[i+0].type==JSON_TYPE_KEY&&(mb.json_line[i+1].type==JSON_TYPE_FALSE||mb.json_line[i+1].type==JSON_TYPE_TRUE))
    {
    l=aaNumRoof(mb.json_line[i+1].len,_32K);
    aaStringNCopy(text,mb.json_text[i+1],l,YES);
    if(mb.json_line[i+1].type==JSON_TYPE_FALSE)     {     mbLog("jjsoN[%-2i/%-2i]= type=KF len=%-4i [%s=%s]",i+0,mb.json.status.lines,mb.json_line[i+0].len+mb.json_line[i+1].len,mb.json_text[i+0],text);    }
    else
    if(mb.json_line[i+1].type==JSON_TYPE_TRUE)     {     mbLog("kjsoN[%-2i/%-2i]= type=KT len=%-4i [%s=%s]",i+0,mb.json.status.lines,mb.json_line[i+0].len+mb.json_line[i+1].len,mb.json_text[i+0],text);     }
    i+=2;
    continue;
    }
   }
  mbLog("ljsoN[%-2i/%-2i]= type=%-2i len=%-4i [%s]",i,mb.json.status.lines,mb.json_line[i].type,mb.json_line[i].len,mb.json_text[i]);
  i++;
  }
 return RET_YES;
 }










 B convertSlashQuotes                  (VP text,H chars,B fwd)
 {
 B ret;
 if(text==NULL) { return RET_BADPARM; }
 if(chars==0)   { aaStringLen(text,&chars); }
 if(fwd)  {  ret=aaStringReplaceString(text,chars,"\"",1,"\\\"",2,NO,text);  }
 else     {  ret=aaStringReplaceString(text,chars,"\\\"",2,"\"",1,NO,text);  }
 return RET_YES;
 if(ret!=RET_YES) { oops; }
 return ret;
 }



/*-----------------------------------------------------------------------*/

 Q global_msg=100000000000LL;
 Q global_msg_counter=1LL;

 Q global_id_counter=100000LL;
 B global_id_block[1000];

/*-----------------------------------------------------------------------*/

 _list room_list={.magic=0};

 H total_messages=0;

 B the_data[_512K];
 H the_len;
 H the_off;

/*-----------------------------------------------------------------------*/





 B globalUuidBlockReset (V)
 {
 Q bs;
 bs=(Q)sizeof(global_id_block);
 global_id_counter+=bs;
 aaMemoryFill(global_id_block,sizeof(global_id_block),0);
 aaDebugf("global=%I64d bs=%I64d",global_id_counter,bs);
 return RET_YES;
 }



 Q globalUuidGenerate (V)
 {
 Q go,bs,id,bi;
 bs=(Q)sizeof(global_id_block);
 go=0;
 id=0;
 while(1)
  {
  go++;
  if(go>=(bs/2))
   {
   globalUuidBlockReset();
   go=0;
   continue;
   }
  bi=aaMathRand64(0,bs);
  bi=bi%bs;
  if(global_id_block[bi]==1) { continue; }
  id=(global_id_counter*bs)+bi;
  global_id_block[bi]=1;
  break;
  }
 return id;
 }






 B serverNew                           (_server*server,H ip,W port,H usrparm,H maxcalls,VP proc)
 {
 B ret;

 if(server==NULL)                  { return RET_MISSINGPARM; }
 aaMemoryFill(server,sizeof(_server),0);
 server->magic=aaHPP(serverNew);
 if(maxcalls==0) { maxcalls=CALL_HANDLE_SPACE; }
 server->max_calls=maxcalls;
 server->user_parm=usrparm;
 if(port==0) { port=80; }
 aaNetAdrSet(&server->adr,ip,port);
 aaDebugf("About to create port");
 if((ret=aaNetTcpPortCreate(&server->port.handle,server->adr.ip,server->adr.port,sizeof(_servercalldata)))!=YES)  { oops;  }
 aaNetTcpPortStatus(server->port.handle,&server->port.status);
 server->proc=proc;
 if((ret=aaMemoryAllocate((VP)&server->ch_array,server->max_calls*sizeof(H)))!=YES) { oops; }
 globalUuidGenerate();
 return RET_YES;
 }









 B serverDelete                        (_server*server)
 {
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 if(server->port.handle!=0)
  {
  aaNetTcpPortStatus(server->port.handle,&server->port.status);
  aaNetTcpPortDestroy(server->port.handle);
  server->port.handle=0;
  }
 if(server->max_calls!=0&&server->ch_array)
  {
  aaMemoryRelease(server->ch_array);
  server->ch_array=NULL;
  }
 aaMemoryFill(server,sizeof(_server),0);
 return RET_YES;
 }







 B serverCallAnswer                    (_server*server)
 {
 B ret;
 H i;
 N ok;
 _servercalldata*cd;

 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 if((ret=aaNetTcpCallAnswer(server->call.handle))!=YES) { oops; }
 aaNetTcpCallInactivityResetOn(server->call.handle,YES,YES);
 aaNetTcpCallStatus(server->call.handle,&server->call.status);
 if(server->call.status.extra_bytes!=sizeof(_servercalldata)) { oof; }
 cd=(_servercalldata*)server->call.status.extra_data;
 cd->ch_array_index=-1;
 cd->ms_ok_last_cmd=aaMsRunning();
 ok=-1;
 for(i=0;i<server->max_calls;i++)  {  if(server->ch_array[i]==0) { ok=(N)i; break; }  }
 if(ok==-1) { oof; }
 cd->ch_array_index=ok;
 server->ch_array[ok]=server->call.handle;
 i=(H)ok;
 cd->id_num=globalUuidGenerate();
 aaStringCopyf(cd->id_buf,"%I64u",cd->id_num);//ran);
 aaStringHancock(cd->hancock,(H)cd->id_num);//cran);
 ///aaDebugf("cd->id=%I64d %s",cd->id_num,cd->id_buf);
 server->cur_calls++;
 server->tot_calls++;
 cd=(_servercalldata*)server->call.status.extra_data;
 ///aaDebugf("new call incoming han=%u",server->call.handle);
 return RET_YES;
 }














 B serverCallDestroy                   (_server*server)
 {
 B ret;
 H i,m;
 N ok;
 Q fb;
 B fn[_1K];

 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 ok=-1;
 for(i=0;i<server->max_calls;i++)
  {
  if(server->ch_array[i]==server->call.handle) { ok=(N)i; break; }
  }
 if(ok==-1) { oof; }
 m=aaElementCount(server->cd->fsu);
 for(i=0;i<m;i++)
  {
  if(server->cd->fsu[i].handle)
   {
   aaFileStreamStatus(server->cd->fsu[i].handle,&server->cd->fsu[i].status);
   fb=server->cd->fsu[i].status.bytes;
   aaStringCopy(fn,server->cd->fsu[i].status.filename);
   ///aaDebugf("closing fsu[%i] bytes=%I64d",i,server->cd->fsu[i].status.bytes);
   ret=aaFileStreamDestroy(server->cd->fsu[i].handle);
   if(ret!=YES) {}
   server->cd->fsu[i].handle=0;
   ///ret=aaFileDelete("%s",fn);
   ///aaDebugf("delete destroy %I64d %s = %s",fb,fn,arets);
   if(fb<_16K)
    {
    aaDebugf("deleting file too small %I64d %s",fb,fn);
    aaFileDelete("%s",fn);
    }
   }
  server->cd->fsu[i].handle=0;
  }
 if(server->cd->shell.magic!=0)
  {
  ///aaDebugf("deleting shell");
  if((ret=aaShellDelete(&server->cd->shell))!=YES) { oops;  }
  }
 server->ch_array[ok]=0;
 aaNetTcpCallDestroy(server->call.handle);
 server->call.handle=0;
 server->cd=NULL;
 server->cur_calls--;
 if(server->cur_calls<=1&&mb.unsubs_flags==YES)
  {
  if(aa_is_morph_pending==0) {  aaRestart(); aaQuit();   }
  }
 return RET_YES;
 }











 B serverYield                         (_server*server,H ita)
 {
 B ret;
 _servercalldata*cd;
 V(*proc)(_server*);

 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 if(ita==0) { ita=1; }
 while(ita--)
  {
  server->cd=NULL;
  aaNetTcpPortStatus(server->port.handle,&server->port.status);
  if(aaNetTcpPortCallNext(server->port.handle,&server->call.handle,&server->call.status,0)!=YES) { continue; }
  if(server->call.status.is_connected!=YES)
   {
   if(server->max_calls>0&&server->port.status.calls_inuse>=server->max_calls)   {  aaNetTcpCallDestroy(server->call.handle);    }
   else                                                                          {  serverCallAnswer(server);    }
   continue;
   }
  if(server->call.status.is_closed)
   {
   ///aaDebugf("han=%u closems=%i",server->call.handle,server->call.status.closed_ms);
   }
  if(server->call.status.extra_bytes!=sizeof(_servercalldata)) { mbLog("eb=%i",server->call.status.extra_bytes); }
  cd=(_servercalldata*)server->call.status.extra_data;
  server->cd=cd;

  switch(cd->do_close)
   {
   case 0:
   break;

   case 1:
   if(cd->room_name[0]!=NULL_CHAR)
    {
    if(cd->type==CALL_TYPE_PEER)     {     serverBroadcastUserLeft(server);     }
    if(cd->type==CALL_TYPE_ROOMER)   {     serverRoomBroadcastLeft(server);     }
    }
   if(cd->is_ws&&cd->wock.is_open)
    {
    if((ret=aaNetWebsocketClose(&cd->wock))!=YES)     {     aaDebugf(">>>> %s %i %s",__FILE__,__LINE__,arets);     }
    }
   ///aaDebugf("calling tcpcallclose, isws=%i isopen=%i room=%s type=%i",cd->is_ws,cd->wock.is_open,cd->room_name,cd->type);
   aaNetTcpCallClose(server->call.handle);
   aaNetTcpCallStatus(server->call.handle,&server->call.status);
   cd->do_close=2;
   ita=0;
   break;

   case 2:
   serverCallDestroy(server);
   ita=0;
   break;
   }

  if(server->cd==NULL)   {   break;   }
  if(server->call.status.is_closed)
   {
   if(cd->do_close==0&&cd->stage<10)
    {
    aaDebugf("setting cd->do_close=1 cd stage=%i",cd->stage);
    cd->do_close=1;
    continue;
    }
   ///aaDebugf("closems=%i",server->call.status.closed_ms);
   }
  if((proc=server->proc))   {   proc(server);   }
  }
 return RET_YES;
 }











 V serverProc                          (_server*server)
 {
 B ret;
 _servercalldata*cd;
 _servergather gather;
 //_tcpcallunit tcall;
 //_servercalldata*tcd;
 B oc,ff;
 H bytes,hv,sl,count;//,ti,d;
 //H i;
 Q fof,fby,line,lines;
 //Q now;
 G from,to,many,m,testcount;
 B fn[_16K];
 B vn[_16K];
 B str[_16K];
 B etc[_1MEG];
 B guid[127];
 H loaded;
 H bi,bo;
 H pos,dd;
 B match[_1K];
 H off,len,todo;
 B chunk[_32K];
 ///B first;

 cd=(_servercalldata*)server->cd;
 switch(cd->stage)
  {
  case 0:
  if((ret=aaNetWebsocketInit(&cd->wock,server->call.handle,0))!=YES) { oops; }
  cd->wock.ping_xmit_last_ms=0;//aaMsRunning();
  cd->wock.pong_xmit_last_ms=0;//aaMsRunning();
  cd->wock.ping_rcve_last_ms=0;//aaMsRunning();
  cd->wock.pong_rcve_last_ms=0;//aaMsRunning();
//  cd->wock.ping_xmit_last_ms+=(H)(PING_TIMEOUT*2);
  //cd->wock.ping_last_ms+=(H)(PING_TIMEOUT*0.75);
  aaNetTcpCallStatus(server->call.handle,&server->call.status);
  ///aaDebugf("websock init sesh=%u han=%u",server->call.status.session,server->call.handle);
  cd->ms_ok_last_cmd=aaMsRunning();
  cd->is_ws=1;
  cd->stage=10;
  break;


  case 3:
  if(cd->do_close==0)   {   cd->do_close=1;   }
  cd->stage=5;
  break;


  case 5:
  cd->do_close=2;
  break;


  case 10:
  if(server->call.status.is_closed)
   {
   /*-----------------------------------------------------------------------*/
   /*-----------------------------------------------------------------------*/
   //mbLog("line=%i isclosed",__LINE__);
   /*-----------------------------------------------------------------------*/
   /*-----------------------------------------------------------------------*/
   cd->stage=3;
   break;
   }
  if((ret=aaNetWebsocketYield(&cd->wock))!=YES) { oops;  }
  if(cd->wock.is_failure)                       { mbLog("line=%i failure a",__LINE__,cd->wock.fail_reason); cd->stage=3;  break; }
  if(server->call.status.ms>=aaSecs(20))        { mbLog("stage10 timeout");  cd->stage=3; break; }
  if(cd->wock.is_open!=YES)                     { break; }
  aaStringLen(cd->wock.url,&sl);
  aaStringCountChars(cd->wock.url,sl,&count,FSLASH_CHAR,NO,YES);
  if((sl<2||sl>21)||(count!=1))
   {
   /*-----------------------------------------------------------------------*/
   /*-----------------------------------------------------------------------*/
   ///mbLog("bad room, fslash=%i sl=%i is=(%s)",count,sl,cd->wock.url);
   /*-----------------------------------------------------------------------*/
   /*-----------------------------------------------------------------------*/
   cd->stage=3;
   break;
   }

  aaStringCopy(cd->room_name,cd->wock.url);
  if(aaStringICompare(cd->wock.url,"/roomer",0)==YES)
   {
   aaStringNull(cd->room_name);
   cd->type=CALL_TYPE_ROOMER;
   cd->stage=1500;
   break;
   }

  if(aaStringICompare(cd->wock.url,"/chunker",0)==YES)
   {
   aaStringNull(cd->room_name);
   cd->type=CALL_TYPE_CHUNKER;
   cd->stage=2000;
   break;
   }

  if(aaStringICompare(cd->wock.url,"/shelly",0)==YES)
   {
   aaStringNull(cd->room_name);
   cd->type=CALL_TYPE_SHELLY;
   cd->stage=5000;
  serverCmdBegins(server,"xfwd");
  serverCmdKeyVal(server,"val","%s",cd->wock.x_forwarded_for);
//  aaStringReplaceString(cd->data,0,"\\",1,"\\\\",2,YES,cd->data);
//  convertSlashQuotes(cd->data,0,YES);
//  serverCmdKeyVal(server,"line","%s",cd->data);
  serverCmdEolFix(server);
  serverCmdFinish(server);
  if((ret=aaNetWebsocketWrite(&cd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES)   {  oops;   }
   //aaDebugf("wock xfwd=%s",cd->wock.x_forwarded_for);
   break;
   }

  /*-----------------------------------------------------------------------*/
  /*-----------------------------------------------------------------------*/
  ///aaDebugf("peer connected url %s",cd->wock.url);
  /*-----------------------------------------------------------------------*/
  /*-----------------------------------------------------------------------*/
///  aaNote(0,"peer connected url %s",cd->wock.url);
  cd->type=CALL_TYPE_PEER;
  cd->do_close=1;
  break;





  /*-----------------------------------------------------------------------*/
  case 1500: //########################## /roomer
  if(cd->do_close) { break; }
  aaNetTcpCallStatus(server->call.handle,&server->call.status);
  if((ret=aaNetWebsocketYield(&cd->wock))!=YES) {  oops; }
  if(cd->wock.is_failure) { aaNote(0,"failure ec %i",cd->wock.fail_reason); }
  websocketPinger(&server->call);
  if((ret=websocketReader(&server->call,&oc,&ff,&bytes,sizeof(the_data),the_data))!=YES) { break; }
  if(oc==WEBSOCKET_OPCODE_CLOSE&&ff==1)
   {
   if(bytes==2)         { hv=*(WP)&the_data[0];  hv=aaNumSwapWord(hv);    }
   ///ebugf("stage = %i, opcode close bytes=%i hv=%02x ",cd->stage,bytes,hv);
   aaNetWebsocketClose(&cd->wock);
   if(cd->do_close==0)    {   cd->do_close=1;    }
   break;
   }
  if(oc==WEBSOCKET_OPCODE_PING&&ff==1)   { cd->wock.ping_rcve_last_ms=aaMsRunning();   websocketPonger(&server->call,bytes,the_data);          break;   }
  if(oc==WEBSOCKET_OPCODE_PONG&&ff==1)   {  cd->wock.pong_rcve_last_ms=aaMsRunning();          break;   }
  //if(oc==WEBSOCKET_OPCODE_BINARY&&ff==1) {   websocketPktDump(&server->call,oc,ff,bytes,the_data);   break;   }
  //if(oc==WEBSOCKET_OPCODE_BINARY&&ff==1)   {
  if((oc==WEBSOCKET_OPCODE_TEXT||oc==WEBSOCKET_OPCODE_BINARY)&&ff==1)
   {
   ///aaDebugf("BINARY, oc=%02x ff=%i  joined = %i, al=%s hc=%s id=%I64d bytes=%i",oc,ff,cd->is_joined,cd->alias,cd->hancock,cd->id_num,bytes);
   if(oc==WEBSOCKET_OPCODE_BINARY)
    {
    ///aaDebugf("BINARY, oc=%02x ff=%i  joined = %i, al=%s hc=%s id=%I64d bytes=%i",oc,ff,cd->is_joined,cd->alias,cd->hancock,cd->id_num,bytes);
    bo=0;
    for(bi=0;bi<bytes;bi++) {   if(the_data[bi]==200) { bo=bi; break; }     }
    the_data[bo]=NULL_CHAR;
    jsonDecode(bo,the_data);
    if(aaStringICompare(mb.json_text[2],"randomvid",0)==YES)
     {
     aaStringToNumber(mb.json_text[6],0,0,0,&from,0);
     aaStringToNumber(mb.json_text[8],0,0,0,&to,0);
     if(from<0||to<0) { break; }
     if(from>to)      { to=from; }
     aaStringCopyf(fn,"uservids/v0/tree/index.txt");
     if((ret=aaFileSizeGet(fn,&fby))!=YES) { aaDebugf("%s size %s",fn,arets); break;   }
     lines=fby/38LL;
     if((fby%38LL)!=0) { aaDebugf("%I64d fby mod =%I64d",fby,fby%38LL); }
     if(lines<1)      { break; }
     if(from>=(G)lines) { from=lines-1; }
     if(to>=(G)lines)   { to=lines-1;   }
     line=aaMathRand64(from,to);//,lines);
     fof=line*38L;
     if((ret=aaFileLoadToBuffer(fn,fof,36,str,&loaded))!=YES) { oops; }
     str[36]=NULL_CHAR;
     if(loaded!=36) { aaNote(0,"loaded=%i",loaded); }
     aaStringCopyf(fn,"uservids/v0/tree/%c/%c/%s",str[0],str[1],str);
     if((ret=aaFileSizeGet(fn,&fby))!=YES) { oops; }
     serverCmdBegins(server,"gotrandvid");
     serverCmdKeyVal(server,"room","%s",cd->room_name);
     serverCmdKeyVal(server,"id","%s",cd->id_buf);
     serverCmdKeyVal(server,"hancock","%s",cd->hancock);
     serverCmdKeyVal(server,"ref",mb.json_text[4]);
     aaStringReplaceChar(fn,0,BSLASH_CHAR,FSLASH_CHAR);
     serverCmdKeyVal(server,"msg","{\\\"filename\\\":\\\"%s\\\",\\\"filesize\\\":%I64d,\\\"line\\\":%I64d,\\\"lines\\\":%I64d}",fn,fby,line,lines);
     serverCmdFinish(server);
     if((ret=aaNetWebsocketWrite(&cd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { oops; }
     break;
     }
    if(aaStringICompare(mb.json_text[2],"listvid",0)==YES)
     {
     aaStringToNumber(mb.json_text[6],0,0,0,&from,0);
     aaStringToNumber(mb.json_text[8],0,0,0,&to,0);
     if(from<0||to<0) { break; }
     if(from>to)      { to=from; }
     aaStringCopyf(fn,"uservids/v0/tree/index.txt");
     if((ret=aaFileSizeGet(fn,&fby))!=YES) { aaDebugf("%s size %s",fn,arets); break;   }
     lines=fby/38LL;
     if((fby%38LL)!=0) { aaDebugf("%I64d fby mod =%I64d",fby,fby%38LL); }
     if(lines<1)       { break; }
     if(from>=(G)lines)   { from=lines-1; }
     if(to>=(G)lines)     { to=lines-1;   }
     many=(to-from)+1;
     if(many>=100)     { many=100; }
     aaStringNull(etc);
     line=from;
     for(m=0;m<many;m++)
      {
      fof=line*38L;
      if((ret=aaFileLoadToBuffer(fn,fof,36,str,&loaded))!=YES) { aaNote(0,"%s\n%s\n%I64d",arets,fn,line);  }
      str[36]=NULL_CHAR;
      if(loaded!=36) { aaNote(0,"loaded=%i",loaded); }
      aaStringCopyf(vn,"uservids/v0/tree/%c/%c/%s",str[0],str[1],str);
      if((ret=aaFileSizeGet(vn,&fby))!=YES) { aaNote(0,"%s\n%s",vn,arets); }
      aaStringReplaceChar(vn,0,BSLASH_CHAR,FSLASH_CHAR);
      aaStringAppendf(etc,"{\\'filename\\':\\'%s\\',\\'filesize\\':%I64d,\\'line\\':%I64d,\\'lines\\':%I64d},",vn,fby,line,lines);
      line++;
      }
     aaStringLastCharDeleteIfChar(etc,0,',');
     serverCmdBegins(server,"gotlistvid");
     serverCmdKeyVal(server,"room","%s",cd->room_name);
     serverCmdKeyVal(server,"id","%s",cd->id_buf);
     serverCmdKeyVal(server,"hancock","%s",cd->hancock);
     serverCmdKeyVal(server,"ref",mb.json_text[4]);
     serverCmdAppend(server,"'msg':'[%s]',",etc);
     serverCmdFinish(server);
     if((ret=aaNetWebsocketWrite(&cd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { oops; }
     break;
     }
    if(aaStringICompare(mb.json_text[2],"filechunk",0)==YES)
     {
     if(cd->fsu[0].handle==0)
      {
      while(1)
       {
       aaStringGuid(guid,NO,YES);
       aaStringCopyf(fn,"C:\\www\\mebeam\\server\\uservids\\v0\\pool\\%s.webm",guid);
       if(aaFileExists(fn)==YES) { continue; }
       if((ret=aaFileStreamCreateQuick(&cd->fsu[0].handle,fn))!=YES) { oops; }
       aaFileStreamStatus(cd->fsu[0].handle,&cd->fsu[0].status);
       break;
       }
      }
     fof=cd->fsu[0].status.offset;
     bo++;
     bytes-=bo;
     if(bytes>0)
      {
      ret=aaFileStreamWrite(cd->fsu[0].handle,bytes,&the_data[bo]);
      if(ret!=YES)       {       oops;       }
      if(aaMathRand32(0,32)==YES)       {       aaFileStreamFlush(cd->fsu[0].handle);       }
      aaFileStreamStatus(cd->fsu[0].handle,&cd->fsu[0].status);
      fby=cd->fsu[0].status.bytes;
      aaStringCopy(fn,cd->fsu[0].status.filename);
      }
     else
      {
      if(cd->fsu[0].handle==0) { oof; }
      aaFileStreamStatus(cd->fsu[0].handle,&cd->fsu[0].status);
      fby=cd->fsu[0].status.bytes;
      aaStringCopy(fn,cd->fsu[0].status.filename);
      ret=aaFileStreamDestroy(server->cd->fsu[0].handle);
      server->cd->fsu[0].handle=0;
      aaDebugf(" ");
      aaDebugf("islast! fbytes=%I64d fn=%s streamdes=%s",fby,fn,arets);
      aaDebugf("rr=%.2fk xr=%.2fk",server->call.status.rcve_rate/1024.0,    server->call.status.xmit_rate/1024.0);
      }
     if(bytes==0||aaMathRand32(0,32)==0)
      {
      if(aaStringFindChar(fn,0,&pos,BSLASH_CHAR,YES,0,NO)==RET_YES)      {       pos++;       }
      else                                                               {       pos=0;       }
      //aaDebugf(">>%s<<",&fn[pos]);
      serverCmdBegins(server,"gotchunk");
      serverCmdKeyVal(server,"room","%s",cd->room_name);
      serverCmdKeyVal(server,"id","%s",cd->id_buf);
      serverCmdKeyVal(server,"hancock","%s",cd->hancock);
      serverCmdKeyVal(server,"ref","%s",mb.json_text[4]);
      aaStringReplaceChar(fn,0,BSLASH_CHAR,FSLASH_CHAR);
      serverCmdKeyVal(server,"msg","{\\\"filename\\\":\\\"%s\\\",\\\"filesize\\\":%I64d,\\\"islast\\\":%s}",&fn[pos],fby,(bytes==0)?"true":"false");
      serverCmdFinish(server);
      if((ret=aaNetWebsocketWrite(&cd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { oops; }
      }
     break;
     }
    aaDebugf("unknown binary cmd=%s",mb.json_text[2]);
    break;
    }

   jsonDecode(bytes,the_data);
   ///jsonDump();
   if(cd->is_joined==NO)
    {
    if(aaStringICompare(mb.json_text[1],"cmd",0)==YES&&aaStringICompare(mb.json_text[2],"join",0)==YES)
     {
     //jsonDump();
     aaStringCopyf(cd->room_name,"%s",mb.json_text[4]);
     if(mb.json_text[6][0]!=NULL_CHAR)
      {
      if(aaStringICompare(mb.json_text[5],"alias",0)==YES) {  aaStringCopyf(cd->hancock,"%s",mb.json_text[6]);       }
      }
     if(mb.json_text[8][0]!=NULL_CHAR)
      {
      if(aaStringICompare(mb.json_text[7],"fingerprint",0)==YES) {  aaStringCopyf(cd->fingerprint,"%s",mb.json_text[8]);       }
      aaDebugf("fingerprint=%s",cd->fingerprint);
      if(aaStringICompare(cd->fingerprint,"cf46a9dd69cb126e274ee50f5331386074de872f6a017e3e1b7407efc19b8e84xx",0)==YES)
       {
       aaDebugf("pervert");
       if(cd->do_close==0) { cd->do_close=1; }
       }
      }
     if(mb.json_text[10][0]!=NULL_CHAR)
      {
      if(aaStringICompare(mb.json_text[9],"envinfo",0)==YES) {  aaStringCopyf(cd->envinfo,"%s",mb.json_text[10]);       }
      }
     if(mb.json_text[12][0]!=NULL_CHAR)
      {
      if(aaStringICompare(mb.json_text[11],"geoinfo",0)==YES) {   }
      }
     if(mb.json_text[14][0]!=NULL_CHAR)
      {
      if(aaStringICompare(mb.json_text[13],"testcount",0)==YES)
       {
       aaStringToNumber(mb.json_text[14],0,0,0,&testcount,0);
       if((ret=serverRoomGather(server,&gather,cd->room_name))!=YES) { oops; }
       aaDebugf("testcnt=%I64d gath=%u",testcount,gather.count);
       if(gather.count>testcount)
        {
        ///aaDebugf("testcount=%I64d, gathererd=%u room=%s, sending full",testcount,gather.count,cd->room_name);
        serverRoomSendFull(server);
        //cd->do_close=1;
        cd->close_delay=aaMsRunning();
        cd->stage=1510;
        break;
        }
       //aaStringCopyf(cd->geoinfo,"%s",mb.json_text[12]);
       }
      }
     //join (100000662) (Olivia Quincychild) [room-fucker] fp=a197c769e454c583326d59e6fd13ef7657c8b26a088eb7591b2ee7d9132cde50
     while(1)
      {
      aaDebugf("join (%s) (%s) [%s]",cd->id_buf,cd->hancock,cd->room_name);
      aaDebugf("     (%s) ",cd->fingerprint);
      //aaDebugf("     (%s) ",cd->envinfo);
      aaDebugf("wock.url=%s",cd->wock.url);
      aaDebugf(" ");
      break;
      }
     serverRoomSendHi(server);
     serverRoomBroadcastUserJoined(server);
     cd->is_joined=YES;
     }
    else
     {
     aaDebugf("joined fail");
     }
    break;
    }
   if(aaStringICompare(mb.json_text[1],"cmd",0)==YES&&aaStringICompare(mb.json_text[2],"scream",0)==YES)
    {
    serverRoomRelayScream(server);
    break;
    }
   if(aaStringICompare(mb.json_text[1],"cmd",0)==YES&&aaStringICompare(mb.json_text[2],"shout",0)==YES)
    {
    aaDebugf("xx %s",mb.json_text[6]);
    serverRoomRelayShout(server);
    break;
    }
   if(aaStringICompare(mb.json_text[1],"cmd",0)==YES&&aaStringICompare(mb.json_text[2],"say",0)==YES)
    {
    serverRoomRelaySay(server);
    break;
    }
   if(aaStringICompare(mb.json_text[1],"cmd",0)==YES&&aaStringICompare(mb.json_text[2],"filechunk",0)==YES)
    {
    jsonDump();
    break;
    }
   aaDebugf("bad cmd, bytes=%i ",bytes);
   //jsonDump();
   } //g699-8jcy 160166253
  else
   {
   aaDebugf("other oc=%02x",oc);
   }
  break;



  case 1510:
  case 1520:
  if(cd->stage==1510)
   {
   if((aaMsRunning()-cd->close_delay)>=3000)
    {
    if(cd->do_close==0) { cd->do_close=1; }
    cd->stage=1520;
    break;
    }
   }
  if(cd->do_close) { break; }
  aaNetTcpCallStatus(server->call.handle,&server->call.status);
  if((ret=aaNetWebsocketYield(&cd->wock))!=YES) { oops; }
  if(cd->wock.is_failure) { aaNote(0,"failure c %i",cd->wock.fail_reason); }
  websocketPinger(&server->call);
  break;







  /*-----------------------------------------------------------------------*/
  case 2000: //########################## /chunker
  if(cd->do_close) { break; }
  aaNetTcpCallStatus(server->call.handle,&server->call.status);
  if((ret=aaNetWebsocketYield(&cd->wock))!=YES) { oops; }
  if(cd->wock.is_failure) { aaNote(0,"failure ec %i",cd->wock.fail_reason); }
  websocketPinger(&server->call);
  if((ret=websocketReader(&server->call,&oc,&ff,&bytes,sizeof(the_data),the_data))!=YES) { break; }
  if(oc==WEBSOCKET_OPCODE_CLOSE&&ff==1)
   {
   if(bytes==2)         { hv=*(WP)&the_data[0];  hv=aaNumSwapWord(hv);    }
   aaNetWebsocketClose(&cd->wock);
   if(cd->do_close==0)    {   cd->do_close=1;    }
   break;
   }
  if(oc==WEBSOCKET_OPCODE_PING&&ff==1)   { cd->wock.ping_rcve_last_ms=aaMsRunning();   websocketPonger(&server->call,bytes,the_data);          break;   }
  if(oc==WEBSOCKET_OPCODE_PONG&&ff==1)   {  cd->wock.pong_rcve_last_ms=aaMsRunning();          break;   }
  if((oc==WEBSOCKET_OPCODE_TEXT||oc==WEBSOCKET_OPCODE_BINARY)&&ff==1)
   {
   if(oc==WEBSOCKET_OPCODE_BINARY)
    {
    ///aaDebugf("BINARY, oc=%02x ff=%i  joined = %i, al=%s hc=%s id=%I64d bytes=%i",oc,ff,cd->is_joined,cd->alias,cd->hancock,cd->id_num,bytes);
    bo=0;
    for(bi=0;bi<bytes;bi++) {   if(the_data[bi]==200) { bo=bi; break; }     }
    the_data[bo]=NULL_CHAR;
    jsonDecode(bo,the_data);
    ///first=NO;
    if(aaStringICompare(mb.json_text[2],"filechunk",0)==YES)
     {
     if(cd->fsu[0].handle==0)
      {
      while(1)
       {
       aaStringGuid(guid,NO,YES);
       aaStringCopyf(fn,"C:\\www\\mebeam\\server\\uservids\\v0\\pool\\%s.webm",guid);
       if(aaFileExists(fn)==YES) { continue; }
       if((ret=aaFileStreamCreateQuick(&cd->fsu[0].handle,fn))!=YES) { oops; }
       aaFileStreamStatus(cd->fsu[0].handle,&cd->fsu[0].status);
       ///first=YES;
       break;
       }
      }
     fof=cd->fsu[0].status.offset;
     bo++;
     bytes-=bo;
     if(bytes>0)
      {
      ret=aaFileStreamWrite(cd->fsu[0].handle,bytes,&the_data[bo]);
      if(ret!=YES)       {       oops;       }
      if(aaMathRand32(0,32)==YES)       {       aaFileStreamFlush(cd->fsu[0].handle);       }
      aaFileStreamStatus(cd->fsu[0].handle,&cd->fsu[0].status);
      fby=cd->fsu[0].status.bytes;
      aaStringCopy(fn,cd->fsu[0].status.filename);
      }
     else
      {
      if(cd->fsu[0].handle==0) { oof; }
      aaFileStreamStatus(cd->fsu[0].handle,&cd->fsu[0].status);
      fby=cd->fsu[0].status.bytes;
      aaStringCopy(fn,cd->fsu[0].status.filename);
      ret=aaFileStreamDestroy(server->cd->fsu[0].handle);
      server->cd->fsu[0].handle=0;
      aaDebugf(" ");
      aaDebugf("islast! fbytes=%I64d fn=%s streamdes=%s",fby,fn,arets);
      aaDebugf("rr=%.2fk xr=%.2fk",server->call.status.rcve_rate/1024.0,    server->call.status.xmit_rate/1024.0);
      }
     //if(first==YES||bytes==0||aaMathRand32(0,32)==0)
     if(1)
      {
      if(aaStringFindChar(fn,0,&pos,BSLASH_CHAR,YES,0,NO)==RET_YES)      {       pos++;       }
      else                                                               {       pos=0;       }
      //aaDebugf(">>%s<<",&fn[pos]);
      serverCmdBegins(server,"gotchunk");
      serverCmdKeyVal(server,"id","%s",cd->id_buf);
      aaStringReplaceChar(fn,0,BSLASH_CHAR,FSLASH_CHAR);
      //serverCmdKeyVal(server,"msg","{\\\"filename\\\":\\\"%s\\\",\\\"filesize\\\":%I64d,\\\"islast\\\":%s}",&fn[pos],fby,(bytes==0)?"true":"false");
      serverCmdKeyVal(server,
      "msg",
      "{\\\"filename\\\":\\\"%s\\\",\\\"filesize\\\":%I64d,\\\"buffered\\\":%I64d,\\\"rcverate\\\":%I64d,\\\"islast\\\":%s}",
      &fn[pos],fby,
      (G)server->call.status.rcve_bytes,
      (G)server->call.status.rcve_rate,
      (bytes==0)?"true":"false");
      serverCmdFinish(server);
      if((ret=aaNetWebsocketWrite(&cd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { oops; }
      }
     break;
     }
    aaDebugf("unknown binary cmd=%s",mb.json_text[2]);
    break;
    }
   }
  break;





  /*-----------------------------------------------------------------------*/
  case 5020: //########### SHELLY
  if(cd->do_close) { break; }
  aaNetTcpCallStatus(server->call.handle,&server->call.status);
  if((ret=aaNetWebsocketYield(&cd->wock))!=YES) { oops; }
  if(cd->wock.is_failure) { aaNote(0,"failure ec %i",cd->wock.fail_reason); }
  websocketPinger(&server->call);
  if((ret=aaShellYield(&cd->shell,SHELL_WAIT_ITA))!=YES) { oops; }

  if(cd->shell.is_ready==YES)
   {
   if((ret=aaShellWritef(&cd->shell,"%s\r\n",cd->cmd))!=YES) { oops; }
   //if((ret=aaShellWritef(&cd->shell,"%s\r\n",cd->cmd))!=YES) { oops; }
   cd->sli=0;
   cd->stage=5040;
   break;
   }
  if((ret=websocketReader(&server->call,&oc,&ff,&bytes,sizeof(the_data),the_data))!=YES) { break; }
  if(oc==WEBSOCKET_OPCODE_CLOSE&&ff==1)
   {
   if(bytes==2)         { hv=*(WP)&the_data[0];  hv=aaNumSwapWord(hv);    }
   aaNetWebsocketClose(&cd->wock);
   if(cd->do_close==0)    {   cd->do_close=1;    }
   break;
   }
  if(oc==WEBSOCKET_OPCODE_PING&&ff==1)   { cd->wock.ping_rcve_last_ms=aaMsRunning();   websocketPonger(&server->call,bytes,the_data);          break;   }
  if(oc==WEBSOCKET_OPCODE_PONG&&ff==1)   {  cd->wock.pong_rcve_last_ms=aaMsRunning();          break;   }
  if((oc==WEBSOCKET_OPCODE_TEXT||oc==WEBSOCKET_OPCODE_BINARY)&&ff==1)
   {

   }
  break;


  case 5040:
  if(cd->do_close) { break; }
  aaNetTcpCallStatus(server->call.handle,&server->call.status);
  if((ret=aaNetWebsocketYield(&cd->wock))!=YES) { oops; }
  if(cd->wock.is_failure) { aaNote(0,"failure ec %i",cd->wock.fail_reason); }
  websocketPinger(&server->call);
  if((ret=aaShellYield(&cd->shell,SHELL_WAIT_ITA))!=YES) { oops; }
  if((ret=aaShellRead(&cd->shell,&cd->is_prompt,&cd->bytes,cd->data))!=YES)
   {
   if(ret==RET_NOTREADY) { break; }
   aaDebugf("%s",arets);
   oops;
   break;
   }

  if(cd->sli>=4&&0)
   {
   //if(cd->is_prompt==1)    {    aaDebugf("---------------------");    }
   //else                    {    aaDebugf("%i prompt=%i sl=%-5i [%s]", cd->sli,cd->is_prompt,strlen(cd->data),cd->data);    }
   }

  aaDebugf("%i prompt=%i sl=%-5i [%s]", cd->sli,cd->is_prompt,strlen(cd->data),cd->data);
  if(cd->is_prompt==1)    {    aaDebugf("---------------------");    }

  cd->sli++;

  if(cd->sli>=3)
   {
   serverCmdBegins(server,"shet");
   serverCmdKeyVal(server,"isprompt","%i",cd->is_prompt);
   aaStringReplaceString(cd->data,0,"\\",1,"\\\\",2,YES,cd->data);
   convertSlashQuotes(cd->data,0,YES);
   serverCmdKeyVal(server,"line","%s",cd->data);
   serverCmdEolFix(server);
   serverCmdFinish(server);
   if((ret=aaNetWebsocketWrite(&cd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES)   {  oops;   }
   }

  if(cd->is_prompt==YES)
   {
   ///aaDebugf("deleting shell");
   if((ret=aaShellDelete(&cd->shell))!=YES) { oops; }
   cd->stage=5000;
   break;
   }


  //aaDebugf("%i %i",cd->is_prompt,cd->bytes);
  if((ret=websocketReader(&server->call,&oc,&ff,&bytes,sizeof(the_data),the_data))!=YES) { break; }
  if(oc==WEBSOCKET_OPCODE_CLOSE&&ff==1)
   {
   if(bytes==2)         { hv=*(WP)&the_data[0];  hv=aaNumSwapWord(hv);    }
   aaNetWebsocketClose(&cd->wock);
   if(cd->do_close==0)    {   cd->do_close=1;    }
   break;
   }
  if(oc==WEBSOCKET_OPCODE_PING&&ff==1)   { cd->wock.ping_rcve_last_ms=aaMsRunning();   websocketPonger(&server->call,bytes,the_data);          break;   }
  if(oc==WEBSOCKET_OPCODE_PONG&&ff==1)   {  cd->wock.pong_rcve_last_ms=aaMsRunning();          break;   }
  if((oc==WEBSOCKET_OPCODE_TEXT||oc==WEBSOCKET_OPCODE_BINARY)&&ff==1)
   {

   }
  break;






  case 5000: //########### SHELLY
  if(cd->do_close) { break; }
  aaNetTcpCallStatus(server->call.handle,&server->call.status);
  if((ret=aaNetWebsocketYield(&cd->wock))!=YES) { oops; }
  if(cd->wock.is_failure) { aaNote(0,"failure ec %i",cd->wock.fail_reason); }
  websocketPinger(&server->call);
  if((ret=websocketReader(&server->call,&oc,&ff,&bytes,sizeof(the_data),the_data))!=YES) { break; }
  if(oc==WEBSOCKET_OPCODE_CLOSE&&ff==1)
   {
   //aaDebugf("shelly do close");
   if(bytes==2)         { hv=*(WP)&the_data[0];  hv=aaNumSwapWord(hv);    }
   aaNetWebsocketClose(&cd->wock);
   if(cd->do_close==0)    {   cd->do_close=1;    }
   break;
   }
  if(oc==WEBSOCKET_OPCODE_PING&&ff==1)   { cd->wock.ping_rcve_last_ms=aaMsRunning();   websocketPonger(&server->call,bytes,the_data);          break;   }
  if(oc==WEBSOCKET_OPCODE_PONG&&ff==1)   {  cd->wock.pong_rcve_last_ms=aaMsRunning();          break;   }

  if((oc==WEBSOCKET_OPCODE_TEXT||oc==WEBSOCKET_OPCODE_BINARY)&&ff==1)
   {
   if(oc==WEBSOCKET_OPCODE_TEXT)
    {
    ///aaDebugf("shelly got cmd");
    jsonDecode(bytes,the_data);
    jsonDump();

    if(aaStringICompare(mb.json_text[3],"data0",0)==YES)
     {
     aaStringNull(cd->cmd);
     aaDebugf("multi");
     for(dd=0;dd<10;dd++)
      {
      aaStringCopyf(match,"data%i",dd);
      if(aaStringICompare(mb.json_text[3+(dd*2)],match,0)==YES)
       {
       aaDebugf("Appending %s",match);
       aaStringAppend(cd->cmd,mb.json_text[4+(dd*2)]);
       //aaStringAppendf(cd->cmd,"%s",mb.json_text[4+(dd*2)]);
       }
      }
     }
    else
     {
     aaStringCopyf(cd->comment,"%s",mb.json_text[4]);
     aaStringCopyf(cd->cmd,"%s",mb.json_text[6]);
     aaDebugf("** %s **, length=%i",cd->comment,strlen(cd->cmd));
     }
    convertSlashQuotes(cd->cmd,0,NO);
    if(aaStringICompare(mb.json_text[2],"comment",0)==YES)
     {
     aaDebugf("**cmnt** %s",cd->cmd);
     //cd->do_close=1;
     break;
     }
    else
    if(aaStringICompare(mb.json_text[2],"shell",0)==YES)
     {
     if((ret=aaShellNew(&cd->shell))!=YES) { oops; return ret; }
     cd->stage=5020;
     }

    }
   else
   if(oc==WEBSOCKET_OPCODE_BINARY)
    {
    oof;
    bo=0;
    for(bi=0;bi<bytes;bi++) {   if(the_data[bi]==200) { bo=bi; break; }     }
    the_data[bo]=NULL_CHAR;
    jsonDecode(bo,the_data);
    jsonDump();
    aaDebugf("unknown binary cmd=%s",mb.json_text[2]);
    if(cd->do_close==0) { cd->do_close=1; }
    break;
    }
   }
  break;

  }
 }










 B serverRoomGather                    (_server*server,_servergather*gather,VP room)
 {
 H i,c;
 _tcpcallunit tcall;
 _servercalldata*tcd;
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 if(gather==NULL)                    { return RET_MISSINGPARM; }
 gather->count=0;
 if(room==NULL)                      { return RET_MISSINGPARM; }
 c=0;
 for(i=0;i<server->max_calls;i++)
  {
  if(c>=server->cur_calls) { break; }
  if(server->ch_array[i]==0) { continue; }
  c++;
  tcall.handle=server->ch_array[i];
  aaNetTcpCallStatus(tcall.handle,&tcall.status);
  tcd=(_servercalldata*)tcall.status.extra_data;
  if(tcd->stage<1000) { continue; }
  if(tcd->room_name[0]==NULL_CHAR) { continue; }
  if(aaStringICompare(tcd->room_name,room,0)!=YES) {  continue; }
  gather->ch_array_index[gather->count]=i;
  gather->count++;
  }
 return RET_YES;
 }










 B serverBroadcastUserJoined           (_server*server)
 {
 B ret;
 H j;
 _servergather room_gather;
 _servercalldata*cd;
 _tcpcallunit tcall;
 _servercalldata*tcd;
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 cd=(_servercalldata*)server->cd;
 if((ret=serverRoomGather(server,&room_gather,cd->room_name))!=YES) { oops; }
 for(j=0;j<room_gather.count;j++)
  {
  tcall.handle=server->ch_array[room_gather.ch_array_index[j]];
  if(tcall.handle==0) { continue; }
  if(tcall.handle==server->call.handle) { continue; }
  aaNetTcpCallStatus(tcall.handle,&tcall.status);
  tcd=(_servercalldata*)tcall.status.extra_data;
  if(tcd->is_ws!=YES)           { continue; }
  if(tcd->wock.is_open!=YES)    { continue; }
  if(tcd->do_close)             { continue; }
  if(tcd->type!=CALL_TYPE_PEER) { oof; }
  if(aaStringICompare(tcd->room_name,cd->room_name,0)!=YES) { oof; }
  serverCmdGeneric(server,"userJoined",cd->room_name,cd->id_buf,cd->hancock);
  serverCmdTee(server,tcd->room_name,tcd->id_buf,tcd->hancock);
  serverCmdFinish(server);
  if((ret=aaNetWebsocketWrite(&tcd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { oops;}
  }
 return RET_YES;
 }









 B serverBroadcastUserLeft             (_server*server)
 {
 B ret;
 H j;
 _servergather room_gather;
 _servercalldata*cd;
 _tcpcallunit tcall;
 _servercalldata*tcd;

 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 cd=(_servercalldata*)server->cd;
 if((ret=serverRoomGather(server,&room_gather,cd->room_name))!=YES) { oops; }
 for(j=0;j<room_gather.count;j++)
  {
  tcall.handle=server->ch_array[room_gather.ch_array_index[j]];
  if(tcall.handle==0) { continue; }
  if(tcall.handle==server->call.handle) { continue; }
  aaNetTcpCallStatus(tcall.handle,&tcall.status);
  tcd=(_servercalldata*)tcall.status.extra_data;
  if(tcd->is_ws!=YES)           { continue; }
  if(tcd->wock.is_open!=YES)    { continue; }
  if(tcd->do_close)             { continue; }
  if(tcd->type!=CALL_TYPE_PEER) { oof; }
  if(aaStringICompare(tcd->room_name,cd->room_name,0)!=YES) { oof; }
  serverCmdGeneric(server,"userLeft",cd->room_name,cd->id_buf,cd->hancock);
  serverCmdTee(server,tcd->room_name,tcd->id_buf,tcd->hancock);
  serverCmdFinish(server);
  if((ret=aaNetWebsocketWrite(&tcd->wock,WEBSOCKET_OPCODE_TEXT,1,0,server->cmd))!=RET_YES) { oops;}
  }
 return RET_YES;
 }







 B serverCmdBegins                     (_server*server,VP fmt,...)
 {
 aaVargsf128K(fmt);
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 server->cmd[0]=NULL_CHAR;
 aaStringNull(server->cmd);
 //aaStringAppendf(server->cmd,"{'cmd':'%s','gms':%I64d,",str128k.buf,global_msg);
 ///aaStringAppendf(server->cmd,"{'cmd':'%s','gms':%I64d,",str128k.buf,global_msg_counter);
 aaStringAppendf(server->cmd,"{'cmd':'%s',",str128k.buf);
 global_msg_counter++;
 global_msg++;
 return RET_YES;
 }







 B serverCmdFinish                     (_server*server)
 {
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 serverCmdEolFix(server);
 aaStringAppendf(server->cmd,"}");
 aaStringReplaceChar(server->cmd,0,'\'',DQUOTE_CHAR);
 aaStringReplaceChar(server->cmd,0,'`',SQUOTE_CHAR);
 return RET_YES;
 }






 B serverCmdFinishEx                   (_server*server)
 {
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 serverCmdEolFix(server);
 aaStringAppendf(server->cmd,"}");
 aaStringReplaceChar(server->cmd,0,'\'',DQUOTE_CHAR);
 aaStringReplaceString(server->cmd,0,"“",1,"\\\"",2,YES,server->cmd);
 aaStringReplaceString(server->cmd,0,"”",1,"\\\"",2,YES,server->cmd);
 return RET_YES;
 }











 B serverCmdEolFix                     (_server*server)
 {
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 aaStringLastCharDeleteIfChar(server->cmd,0,',');
 return RET_YES;
 }










 B serverCmdKeyVal                     (_server*server,VP key,VP fmt,...)
 {
 if(strlen(key)>_32K) { mbLog("cmdKeyval slen=%i",strlen(key)); }
 aaVargsf128K(fmt);
 if(str128k.len>_64K) { mbLog("vallen=%i",str128k.len); }
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 aaStringAppendf(server->cmd,"'%s':'%s',",key,str128k.buf);
 return RET_YES;
 }







 B serverCmdKeyInt                     (_server*server,VP key,G val)
 {
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 aaStringAppendf(server->cmd,"'%s':%I64d,",key,val);
 return RET_YES;
 }







 B serverCmdKeyDub                     (_server*server,VP key,D val)
 {
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 aaStringAppendf(server->cmd,"'%s':%.3f,",key,val);
 return RET_YES;
 }






 B serverCmdAppend                     (_server*server,VP fmt,...)
 {
 aaVargsf128K(fmt);
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 aaStringAppendf(server->cmd,"%s",str128k.buf);
 return RET_YES;
 }







 B serverCmdString                     (_server*server,VP fmt,...)
 {
 aaVargsf128K(fmt);
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 aaStringAppendf(server->cmd,"'%s'",str128k.buf);
 return RET_YES;
 }










 B serverCmdGeneric                    (_server*server,VP cmd,VP room,VP uuid,VP hancock)
 {
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 serverCmdBegins(server,cmd);
 serverCmdKeyVal(server,"room","%s",room);
 serverCmdKeyVal(server,"id","%s",uuid);
 serverCmdKeyVal(server,"hancock","%s",hancock);
 return RET_YES;
 }








 B serverCmdTee                        (_server*server,VP troom,VP tuuid,VP thancock)
 {
 if(server==NULL)                    { return RET_MISSINGPARM; }
 if(server->magic!=aaHPP(serverNew)) { return RET_NOTINITIALIZED; }
 serverCmdKeyVal(server,"troom","%s",troom);
 serverCmdKeyVal(server,"tid","%s",tuuid);
 serverCmdKeyVal(server,"thancock","%s",thancock);
 return RET_YES;
 }





