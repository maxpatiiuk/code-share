import { RA } from './common';
import { LinkedList } from './linkedList';

export class HashTable {
  public readonly buckets: RA<LinkedList<number>>;

  private readonly size: number;

  public constructor(size: number) {
    this.size = size;
    this.buckets = Array.from({ length: size }, () => new LinkedList<number>());
  }

  public insert(data: number): boolean {
    const index = data % this.size;
    if (this.buckets[index].has(data)) return false;
    this.buckets[index].insert(data);
    return true;
  }

  public delete(data: number): boolean {
    const index = data % this.size;
    if (!this.buckets[index].has(data)) return false;
    this.buckets[index].delete(data);
    return true;
  }

  public *[Symbol.iterator]() {
    return this.buckets;
  }
}

HashTable.prototype.toString = function toString(): string {
  return this.buckets
    .map((bucket, index) => `Bucket ${index}: ${bucket.toString()}`)
    .join('\n');
};
