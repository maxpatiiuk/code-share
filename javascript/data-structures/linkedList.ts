import { RA } from './common';

class ListNode<T> {
  public readonly data: T;
  public next: ListNode<T> | undefined;
  public constructor(data: T) {
    this.data = data;
  }
}

export class LinkedList<T> {
  private head: ListNode<T> | undefined;
  public isEmpty(): boolean {
    return typeof this.head === 'undefined';
  }
  public length(): number {
    return Array.from(this).length;
  }
  public insert(data: T): void {
    const previousHead = this.head;
    this.head = new ListNode<T>(data);
    this.head.next = previousHead;
  }
  public delete(data: T): void {
    let previous = undefined;
    for (let pointer = this.head; typeof pointer !== 'undefined'; )
      if (pointer.data === data) {
        if (typeof previous === 'undefined')
          if (typeof this.head === 'undefined') return;
          else this.head = this.head.next;
        else previous.next = pointer.next;
        return;
      } else {
        previous = pointer;
        pointer = pointer.next;
      }
  }
  public has(data: T): boolean {
    return Array.from(this).some((value) => value === data);
  }
  public appendList(newLinkedList: LinkedList<T>): void {
    const originalList = this.head;

    let iterator = newLinkedList.head;
    if (typeof iterator === 'undefined') return;

    this.head = new ListNode<T>(iterator.data);
    let pointer = this.head;

    iterator = iterator.next;
    while (typeof iterator !== 'undefined') {
      pointer.next = new ListNode<T>(iterator.data);
      pointer = pointer.next;
      iterator = iterator.next;
    }
    pointer.next = originalList;
  }
  public appendArray(newArray: RA<T>): void {
    if (newArray.length === 0) return;
    const newLinkedList = new LinkedList<T>();
    newArray.forEach((item) => newLinkedList.insert(item));
    newLinkedList.reverse();
    this.appendList(newLinkedList);
  }
  public *[Symbol.iterator]() {
    for (
      let pointer = this.head;
      typeof pointer !== 'undefined';
      pointer = pointer.next
    )
      yield pointer.data;
  }
  public get [Symbol.toStringTag](): string {
    return `LinkedList (${this.length()})`;
  }
  public reverse(): void {
    if (typeof this.head === 'undefined') return;

    let pointer = this.head;
    let next = pointer.next;
    pointer.next = undefined;
    for (let previous; typeof next !== 'undefined'; pointer.next = previous) {
      previous = pointer;
      pointer = next;
      next = next.next;
    }
    this.head = pointer;
  }
}

LinkedList.prototype.toString = function toString(): string {
  return Array.from(this).join(', ');
};
