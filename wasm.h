
 #include <stdint.h>


 #define RET_NO                        0
 #define RET_OK                        1
 #define RET_YES                       1
 #define RET_BADPARM                   2
 #define RET_FAILED                    3
 #define RET_BOUNDS                    4
 #define RET_FORBIDDEN                 5
 #define RET_NOMEMORY                  6
 #define RET_BADHANDLE                 7
 #define RET_NOTFOUND                  8
 #define RET_NOTREADY                  9
 #define RET_EXISTS                    10
 #define RET_ALREADYOPEN               11
 #define RET_NOTOPEN                   12
 #define RET_INUSE                     13
 #define RET_NOTSTARTED                14
 #define RET_CORRUPTED                 15
 #define RET_NOTSUPPORTED              16
 #define RET_DENIED                    17
 #define RET_TIMEOUT                   18
 #define RET_FATAL                     19
 #define RET_BADSTATE                  20
 #define RET_FINISHED                  21
 #define RET_NOTINITIALIZED            22
 #define RET_PARTIAL                   23
 #define RET_ALREADYSTARTED            24
 #define RET_ATTENTION                 25
 #define RET_BADFORMAT                 26
 #define RET_CANCELLED                 27
 #define RET_WORKING                   28
 #define RET_COLLISION                 29
 #define RET_POSSIBLE                  30
 #define RET_IGNORE                    31
 #define RET_INCOMPLETE                32
 #define RET_OTHER                     33
 #define RET_MISSINGPARM               34
 #define RET_OVERFLOW                  35
 #define RET_STILLWORKING              36
 #define RET_SAME                      37
 #define RET_UNDERFLOW                 38
 #define RET_UNKNOWN                   39

/*-----------------------------------------------------------------------*/


 #define T                             typedef
 #define structure                     typedef struct
 #define unite                         typedef union

 #define WEX(name)                     __attribute__((export_name(#name))) name

/*-----------------------------------------------------------------------*/


 T void                                v0;
 T void           *                    v0p;

 T int8_t                              s8;
 T int16_t                             s16;
 T int32_t                             s32;
 T int64_t                             s64;
 T int8_t         *                    s8p;
 T int16_t        *                    s16p;
 T int32_t        *                    s32p;
 T int64_t        *                    s64p;

 T uint8_t                             u8;
 T uint16_t                            u16;
 T uint32_t                            u32;
 T uint64_t                            u64;
 T uint8_t        *                    u8p;
 T uint16_t       *                    u16p;
 T uint32_t       *                    u32p;
 T uint64_t       *                    u64p;

 T float                               f32;
 T float          *                    f32p;

 T double                              d64;
 T double         *                    d64p;


/*-----------------------------------------------------------------------*/


 #define aaCast(ptr,type,obj)          ptr=(type)obj
 #define aaCastS64(ptr,off)            *(s64p)&ptr[off<<4]
 #define aaCastU64(ptr,off)            *(u64p)&ptr[off<<4]
 #define aaCastS32(ptr,off)            *(s32p)&ptr[off<<2]
 #define aaCastU32(ptr,off)            *(u32p)&ptr[off<<2]
 #define aaCastS16(ptr,off)            *(s16p)&ptr[off<<1]
 #define aaCastU16(ptr,off)            *(u16p)&ptr[off<<1]
 #define aaCastS8(ptr,off)             *(s8p)&ptr[off<<0]
 #define aaCastU8(ptr,off)             *(u8p)&ptr[off<<0]

 #define YES                           1
 #define NO                            0

 #define aaBool(obj)                   (!(!(obj)))
 #define aaBoolString(obj)             (obj)?"YES":"NO "
 #define aaBoolStrings(obj,ts,fs)      (obj)?ts:fs
 #define aaBoolChar(obj)               (obj)?'Y':'N'
 #define aaBoolChars(obj,tc,fc)        (obj)?tc:fc

 #define aaBitSet(obj,pos)             ((obj)|(1LL<<(pos)))
 #define aaBitClr(obj,pos)             ((obj)&~(1LL<<(pos)))
 #define aaBitGet(obj,pos)             aaBool((obj)&(1LL<<(pos)))
 #define aaBitIsOn(obj,pos)            aaBool((obj)&(1LL<<(pos)))
 #define aaBitIsOff(obj,pos)           (!aaBool((obj)&(1LL<<(pos))))
 #define aaBitToggle(obj,pos)          ((obj)^(1LL<<(pos)))
 #define aaBitAdd(obj,pos,val)         ((obj)+((u64)val<<pos))
 #define aaBitSub(obj,pos,val)         ((obj)-((u64)val<<pos))
 #define aaBitAnd(obj,val)             ((obj)&(u64)val)
 #define aaBitShl(obj,cnt)             ((obj)<<(u64)cnt)
 #define aaBitShr(obj,cnt)             ((obj)>>(u64)cnt)

 #define NULL                          ((v0p)0)

 #define sizet                         unsigned long

/*-----------------------------------------------------------------------*/

 #define aaPi                          3.141592653589793
 #define aaPi2                         6.283185307179586
 #define aaE                           2.718281828459045

/*-----------------------------------------------------------------------*/


 extern v0 ext_consoleLog              (u32 value);
 extern v0 ext_consoleAlert            (u32 value);
 extern v0 ext_consoleText             (u32 value);
 extern v0 ext_consoleFog              (char* ptr, int length);

 ///----------

 extern d64 ext_sin                    (d64 x);
 extern d64 ext_log                    (d64 x);
 extern d64 ext_cos                    (d64 x);
 extern d64 ext_atan2                  (d64 x,d64 y);
 extern d64 ext_log2                   (d64 x);
 extern d64 ext_round                  (d64 x);
 extern d64 ext_sqrt                   (d64 x);
 extern d64 ext_pow                    (d64 x,d64 y);

 ///----------


/*-----------------------------------------------------------------------*/

 v0p my_memset  (v0*str,s32 c,sizet n);
 v0p my_memcpy  (v0*dst,v0*src,sizet count);
 v0p my_memmove (v0*dst,v0*src,sizet count);

/*-----------------------------------------------------------------------*/
