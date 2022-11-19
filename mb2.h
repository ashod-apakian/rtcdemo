/*-----------------------------------------------------------------------*/
 #pragma once
 #ifndef INC_MB_H
 #define INC_MB_H
 #define PUB                           extern
 #ifdef __cplusplus
 PUB "C" {
 #endif
/*-----------------------------------------------------------------------*/
 #include "aa.h"
/*-----------------------------------------------------------------------*/
 #define MB_VERSION                    "2"
 #define DEV_VERSION                   "0.80"
 #define AUTO_MINIMIZE                 4100
/*-----------------------------------------------------------------------*/

 #define I_AM_UNKNOWN                  0
 #define I_AM_GOOGLE_CLOUD             1
 #define I_AM_AMAZON_CLOUD             2
 #define I_AM_DESKTOP                  3
 #define I_AM_THINKPAD                 4
 #define I_AM_GIGA                     5
 #define I_AM_GODADDY                  6
 #define I_AM_DIGITALPACIFIC           7

/*-----------------------------------------------------------------------*/

 #define MAX_JSON_LINES                256


 structure
 {
 H magic;
 B do_quit;
 _systime launch_time;
 B launch_text[65];
 _info info;
 Q log_counter;
 Q log_ms;
 B manu[513];
 N who_i_am;
 _surfaceunit surf;
 H tray_icon_index;
 Q tray_icon_ms;
 _surfaceunit canvas;
 Q canvas_update_ms;
 _fontunit font[1];
 B is_uploading_upgrade;
 D upload_complete;

 _jsonunit json;
 _jsonline json_line[MAX_JSON_LINES];
 B json_text[MAX_JSON_LINES][_64K];

 //_jsonunit jot;
 //_jsonline jot_line[MAX_JSON_LINES];
 ///B jot_text[MAX_JSON_LINES][_64K];

 Q billhits;
 B billboard[10][257];

 B unsubs_flags;
 }
 _mb;


/*-----------------------------------------------------------------------*/


 B mbStart                             (V);
 V mbStop                              (V);
 B mbBillboard                         (VP fmt,...);
 B mbStats                             (V);
 B mbYield                             (V);
 B mbLog                               (VP fmt,...);

/*-----------------------------------------------------------------------*/


/*-----------------------------------------------------------------------*/



 //B jotDecode                           (H bytes,VP data);
 //B jotDump                             (B mode);

 B jsonDecode                          (H bytes,VP data);
 B jsonDump                            (V);
 B convertSlashQuotes                  (VP text,H chars,B fwd);

 B jsonDescriber                       (H bytes,VP data,B show);

/*-----------------------------------------------------------------------*/

 B websocketPktDump                    (_tcpcallunit*call,B oc,B ff,H bytes,VP data);
 B websocketPinger                     (_tcpcallunit*call);
 B websocketPonger                     (_tcpcallunit*call,H bytes,VP data);
 B websocketReader                     (_tcpcallunit*call,BP oc,BP ff,HP bytes,H maxbytes,VP data);

 #define PING_TIMEOUT                  40000

/*-----------------------------------------------------------------------*/

 #define CALL_TYPE_PEER                1
 #define CALL_TYPE_DASHBOARD           2
 #define CALL_TYPE_ELOG                3
 #define CALL_TYPE_ROOMER              4
 #define CALL_TYPE_CHUNKER             5
 #define CALL_TYPE_SHELLY              6


 #define MB_GUIDE_STATE_UNUSED         0
 #define MB_GUIDE_STATE_INUSE          1
 #define MB_GUIDE_STATE_CLOSING        3
 #define MB_GUIDE_STATE_READY          4


 #define CALL_HANDLE_SPACE             128

 structure
 {
 H count;
 //N guide_index[100];
 N ch_array_index[CALL_HANDLE_SPACE];
 }
 _servergather;



 structure
 {
 H state;
 H call_handle;
 H call_session;
 B id_buf[150];
 Q id_num;
 B room_name[720];
 H type;
 }
 _serverguide;


 structure
 {
 H stage;
 H type;
 N ch_array_index;
 B is_ws;
 B is_joined;
 B do_close;
 Q close_delay;
 B id_buf[50];
 Q id_num;
 B hancock[65];
 B room_name[720];
 B channel[65];
 B alias[65];
 B fingerprint[65];
 B envinfo[513];
 B geoinfo[257];
 _websocket wock;
 Q ms_ok_last_cmd;
 D mic_level;
 _filestreamunit fsu[4];
 B cmd[_64K];
 _shell shell;
 B comment[_2K];
 H sli;
 H bytes;
 B data[_64K];
 B is_prompt;

 }
 _servercalldata;



 structure
 {
 H magic;
 H user_parm;
 H max_calls;
 H cur_calls;
 Q tot_calls;
 _netadr adr;
 _tcpportunit port;
 _tcpcallunit call;
 _servercalldata*cd;
 HP ch_array;
 B cmd[_512K];
 VP proc;
 }
 _server;


/*-----------------------------------------------------------------------*/

 B serverNew                           (_server*server,H ip,W port,H usrparm,H maxcalls,VP proc);
 B serverDelete                        (_server*server);
 B serverGuideEmptyFind                (_server*server,NP index);
 B serverGuideFindByCallHandle         (_server*server,NP index,H callhandle,H callsesh);
 B serverGuideFindById                 (_server*server,NP index,VP uuid);
 B serverCallAnswer                    (_server*server);
 B serverCallDestroy                   (_server*server);
 B serverYield                         (_server*server,H ita);
 V serverProc                          (_server*server);

 B serverOnMessage                     (_server*server,H bytes,VP data);

 B serverRoomGather                    (_server*server,_servergather*gather,VP room);
 B serverChannelGather                 (_server*server,_servergather*gather,VP channel);

 B serverCmdBegins                     (_server*server,VP fmt,...);
 B serverCmdFinish                     (_server*server);
 B serverCmdFinishEx                   (_server*server);
 B serverCmdEolFix                     (_server*server);
 B serverCmdKeyVal                     (_server*server,VP key,VP fmt,...);
 B serverCmdKeyInt                     (_server*server,VP key,G val);
 B serverCmdKeyDub                     (_server*server,VP key,D val);
 B serverCmdAppend                     (_server*server,VP fmt,...);
 B serverCmdString                     (_server*server,VP fmt,...);

 B serverCmdGeneric                    (_server*server,VP cmd,VP room,VP id,VP hancock);
 B serverCmdTee                        (_server*server,VP troom,VP tid,VP thancock);
 B serverCmdAliImgTxt                  (_server*server,VP ali,VP img,VP txt);


 B serverSendWelcome                   (_server*server);
 B serverBroadcastUserJoined           (_server*server);
 B serverBroadcastUserLeft             (_server*server);

 B serverOnMyIceOffer                  (_server*server);
 B serverOnMyIceAnswer                 (_server*server);

 B serverOnMyIceCandidate              (_server*server);

 B serverOnMicLevel                    (_server*server);

 ///B serverOnChatMsg                     (_server*server);
 B serverOnChatMsgEcho                 (_server*server);
 B serverOnCallMsgEcho                 (_server*server);

 B serverOnChatMsgReplay               (_server*server);

 B serverOnVideoBlob                   (_server*server);

 B serverOnElog                        (_server*server);
 B serverOnUpdateSubs                  (_server*server);


 B serverOnMyBookmarks                 (_server*server);
 B serverOnMySubs                      (_server*server);

 B serverOnSubShot                     (_server*server,H bytes,VP data);
 B serverOnDashReq                     (_server*server,H bytes,VP data);

 B serverRoomSendHi                    (_server*server);
 B serverRoomBroadcastJoined           (_server*server);
 B serverRoomBroadcastLeft             (_server*server);
 B serverRoomRelayScream               (_server*server);
 B serverRoomRelayShout                (_server*server);
 B serverRoomRelaySay                  (_server*server);


/*-----------------------------------------------------------------------*/




 structure
 {
 Q last_utc_of_msg;
 Q count;
 }
 _roomlistdata;








/*-----------------------------------------------------------------------*/



 structure
 {
 B room[65];
 Q utc;
 }
 _markentry;



 structure
 {
 N subs_idx;
 B end_point[1025];
 B expire[129];
 B auth[257];
 B p256dh[257];
 //
 N dig_idx;
 B dig_str[257];
 N mark_idx;
 N mark_count;
 _markentry mark_entry[100];
 //
 B state;
 //
 N nfo_idx;
 N nfo_pair_count;
 B nfo_pair[32][2][257];
 }
 _ashot;






 B subShotPrint                        (_server*server,_ashot*ashot,B what);
 B subShotProcess                      (_server*server,_ashot*ashot);
 B subShotValidate                     (_server*server,_ashot*ashot);

/*-----------------------------------------------------------------------*/


 B subsWalk                            (V);

 B roomUtcGet                          (VP room,QP lastutcmsg);
 B roomUtcUpdate                       (VP room,Q lastutcmsg);
 B roomUtcRemove                       (VP room);

/*-----------------------------------------------------------------------*/


/**

 structure
 {
 H magic;
 H ostage;
 H stage;
 B clipname[_1K];
 B extension[257];
 B poolpath[_1K];
 B treepath[_1K];
 B srcfilepath[_1K];
 B dstfilepath[_1K];
 B finfilepath[_1K];
 B srcfilename[_1K];
 B dstfilename[_1K];
 B srcfilename_jpg[_1K];
 B dstfilename_jpg[_1K];
 B cmd[_4K];
 H diren_index;
 _dirunit dir;
 _shell shell;
 H sli;
 B is_prompt;
 H bytes;
 B data[_32K];
 Q tik,ela,pau;
 }
 _ffmpegcroner;

 B ffmpegCronerDirClose                (_ffmpegcroner*fmpcron);
 B ffmpegCronerDirOpen                 (_ffmpegcroner*fmpcron);
 B ffmpegCronerDirProcess              (_ffmpegcroner*fmpcron);
 B ffmpegCronerDirWalk                 (_ffmpegcroner*fmpcron);
 B ffmpegCronerPauseBegin              (_ffmpegcroner*fmpcron,Q pause);
 B ffmpegCronerPauseWait               (_ffmpegcroner*fmpcron);
 B ffmpegCronerFfmpegExecute           (_ffmpegcroner*fmpcron);
 B ffmpegCronerFfmpegExecuteTwo        (_ffmpegcroner*fmpcron);
 B ffmpegCronerFfmpegProcess           (_ffmpegcroner*fmpcron);
 B ffmpegCronerFfmpegFinalise          (_ffmpegcroner*fmpcron);
 B ffmpegCronerShellStart              (_ffmpegcroner*fmpcron);
 B ffmpegCronerShellStop               (_ffmpegcroner*fmpcron);
 B ffmpegCronerShellWait               (_ffmpegcroner*fmpcron,H ita);
 B ffmpegCroner                        (_ffmpegcroner*fmpcron);

 */

 #define SHELL_WAIT_ITA                10




/*-----------------------------------------------------------------------*/


/*


 structure
 {
 H magic;
 H self_index;
 H ostage;
 H stage;
 B cmd[_4K];
 _shell shell;
 H sli;
 B is_prompt;
 H bytes;
 B data[_32K];
 B to[_1K];
 B body[_1K];
 Q tik,ela,pau;
 }
 _smsjob;



 structure
 {
 H magic;
 H job_slots;
 H job_count;
 H job_pf;
 _smsjob*job;
 }
 _smsboss;


 B smsbossNew                          (_smsboss*smsboss);
 B smsbossDelete                       (_smsboss*smsboss);
 B smsbossYield                        (_smsboss*smsboss);

 B smsjobNew                           (_smsboss*smsboss,NP jobindex,VP to,VP body);
 B smsjobDelete                        (_smsboss*smsboss,N jobindex);
 B smsjobYield                         (_smsboss*smsboss,N jobindex);


*/





/*-----------------------------------------------------------------------*/

 V bibleMaker                          (V);

/*-----------------------------------------------------------------------*/

// C:\kode\20_george\libcurl.dll.a
//C:\libs\curl-7.65.3-win32-mingw\include\curl


 PUB _mb     mb;
 PUB _server the_server;
// PUB _webushsys webushsys;
 ///PUB _ffmpegcroner ffmpegcroner;

 PUB _list room_list;
 //PUB _list subs_list;
 //PUB _list sesh_list;
 //PUB _maria maria;

/*-----------------------------------------------------------------------*/
 #endif
/*-----------------------------------------------------------------------*/
 #ifdef __cplusplus
 }
 #endif






