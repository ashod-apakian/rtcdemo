
 #include "wasm.h"

/*-----------------------------------------------------------------------*/


 u32 memory_len=0;


/*-----------------------------------------------------------------------*/


 v0p my_memset  (v0*str,s32 c,sizet n)
 {
 u8*p=str;
 while(n--)  {  *p++=(u8)c;  }
 return str;
 }



 v0p my_memcpy  (v0*dst,v0*src,sizet count)
 {
 s32 i;
 s8*src_char;
 s8*dst_char;
 src_char=(s8*)src;
 dst_char=(s8*)dst;
 for(i=0;i<count;i++)  {  dst_char[i]=src_char[i];  }
 return dst;
 }



 v0p my_memmove (v0*dst,v0*src,sizet count)
 {
 u8p d,s;
 sizet i;
 d=(u8p)dst;
 s=(u8p)src;
 if(d>s&&d<s+count)  {  for(i=count;i-->0;)  { d[i]=s[i]; }  }
 else                {  for(i=0;i<count;i++) { d[i]=s[i]; }  }
 return d;
 }



/*-----------------------------------------------------------------------*/



 v0 WEX (wasmMain)        (u32 membytes)
 {
 memory_len=membytes;
 }


/*-----------------------------------------------------------------------*/


