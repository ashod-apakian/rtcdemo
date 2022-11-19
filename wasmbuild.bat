 cls

clang   --target=wasm32 -nostdlib -O0  -o C:\Windows\TEMP\inc.o -c wasm.c
wasm-ld --no-entry --lto-O0 --allow-undefined --import-memory --export-dynamic C:\Windows\TEMP\inc.o -o wasm.wasm
rem wasm-ld --no-entry --lto-O0 --allow-undefined --import-memory --export-all C:\Windows\TEMP\inc.o -o wasm.wasm

dir wasm.wasm



