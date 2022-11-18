// BASICS
x0  // ref to 0
add x1, x2, x3  // x1=x2+x3  // sub
// memory addresses like offset(base)  // 4(x0)  // sp(x2)

// THEORY
// Big Endian - MSB first
// Little Endian - LSB first

// CONVENTION
// add `i` if last param is const
addi x1, x2, 3  // x1=x2+3
// -i for const
// -u for unsigned
// -z for zero

// ARITHMETIC
and x1, x2, x3  // x1=x3&&x3  // or xor
slt x1, x2, x3  // x1=int(x2<x3)
sltu x1, x2, x3  // unsigned slt
sll x1, x2, x3  // x1=x2<<x3  // srl
sra x1, x2, x3  // arithmetic right shift

// COMPARE & BRANCH
beq x1, x2, else  // x1==x2 && else()
beq  // ==
bne  // !=
blt  // <
bge  // >=
bltu  // <
bgeu  // >=
beqz x1, label  // x1==0 && else()  // beq against 0  // bnez bltz ...

// JUMP
j label  // jumpt to target
jal ra, label  // jump to label and store link in ra (return address)
jalr ra, 4(x1)  // jump to x1+4 and store link in ra
jr x1  // go back to return address

// LOAD & SAVE
lw x1, 0x4(x0)  // load into x1 from 0x4(x0)
sw x1, 0x10(x0)  // save into 0x10(x0) from x1
lui x2, 0x3  // x2=0x3000  // load immediate
li x1, 3  // x1=3  // load immediate
lb, lbu, sb  // load byte (1)
lh, lhu, sh  // load halfword (2)
lw, sw  // load word (4)


// PSEUDOINSTRUCTIONS
mv x1 x2  // addi x1, x2, 0
ble x1, x2, label  // bge x2, x1, label
li x2, 3  // addi x2, x0, 3
li x3, 0x4321  // li for big  // lui x3, 0x4; addi x3, x3, 0x321

// NAMING POINTERS
// a0-a7 - x10-x17 - function arguments (caller)
// a0-a1 - x10-x11 - function return values (caller)
// ra - x1 - return address (caller)
// t0-t6 - x5-7, x28-31 - temp values (caller)
// s0-s11 - x8-9, x18-27 - saved registers (calle)
// sp - x2 - stack pointer (calle)
// gp - x3 - global pointer
// tp - x4 - thread pointer
// zero - x0 - hardwired zero
// caller-saved - not preserverd acrsoll calls; calle can overwrite
// calle-saved - preseverd acrsoll calls

// PROCEDURE
f:
	// saving s0 and s1 to the call stack before changing them
	addi sp, sp, -8
	sw s0, 4(sp)
	sw s1, 0(sp)
	
	// doing operations on them
	addi s0, a0, 3
	li s1, 123456
	add s1, at, s1
	or a0, s0, s1  // saving the response into `a0`

	// restoring previous s0 and s1
	lw s1, 0(sp)
	lw s0, 4(sp)
	addi sp, sp, 8

	ret  // return to return address

li a0, 1
li a1, 2
addi sp, sp, -8
sw ra, 0(sp)  // save return address
sw a1, 4(sp)  // save a1 as it would be used again
jal ra, sum
lw a1, 4(sp)
jal ra, sum
lw ra, 0(sp)
addi sp, sp, x8

