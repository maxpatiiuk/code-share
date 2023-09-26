/*
 * Impressions:
 * - Very limited capabilities (no sum, join, group by)
 *   - They say you have to maintain your own counter if you need sum
 *     That means extra (imperative) code, and likely bugs
 * - Very low limits (20 operations per transaction/batch)
 * - No schema, means you have to do defensive programming or manual
 *   migrations
 *
 *
 * The low-latency, offline, and scalability are nice, but not needed in
 * my common use cases, so I would say Firebase doesn't fit my needs
 * well
 */

import {
  addDoc,
  and,
  collection,
  deleteDoc,
  doc,
  getDoc,
  getDocs,
  limit,
  onSnapshot,
  or,
  orderBy,
  query,
  runTransaction,
  setDoc,
  updateDoc,
  where,
  writeBatch,
} from 'firebase/firestore';

const employee = await getDoc(doc(db, 'employees', '1'));
if (!employee.exists()) {
  await addDoc(collection(db, 'employees'), { name: '1' });
}

(employee.exists() === false) === (employee.data() === undefined);

await getDocs(collection(db, 'employees'));
await setDoc(doc(db, 'employees', '1'), { name: '1' }, { merge: true });
await updateDoc(doc(db, 'employees', '1'), { name: '1' });
await deleteDoc(doc(db, 'employees', '1'));

/*
 * Note: transactions and batches are limited to 20 operations max
 * (likely to not cause latency for other users)
 * Thus I will likely not be using them (not expecting much performance
 * difference)
 * OR, I could try doing all modifications in parallel
 */
const result = await runTransaction(db, async (transaction) => {
  const employee = await transaction.get(doc(db, 'employees', '1'));
  if (!employee.exists()) {
    await transaction.set(doc(db, 'employees', '1'), { name: '1' });
  } else {
    await transaction.update(doc(db, 'employees', '1'), {
      name: `_${employee.data().name}`,
    });
  }

  return 'a' as const;
});
console.log(result);

const batch = writeBatch(db);
batch.set(doc(db, 'employees', '1'), { name: '1' });
batch.update(doc(db, 'employees', '1'), { name: '1' });
batch.delete(doc(db, 'employees', '1'));
await batch.commit();

// < <= == > >= != array-contains array-contains-any in not-in
query(
  collection(db, 'employees'),
  and(
    where('isActive', '==', true),
    or(where('employee', 'in', ['1', '2', '3']), where("name","!=","Test")),
  ),
  orderBy('employee'),
  limit(3),
);

const q = query(collection(db, 'employees'), where('isActive', '==', true));

const querySnapshot = await getDocs(q);
querySnapshot.forEach((doc) => {
  // doc.data() is never undefined for query doc snapshots
  console.log(doc.id, ' => ', doc.data());
});

// Will be re-called on changes
const unsubscribe = onSnapshot(
  q,
  async (querySnapshot) => {
    querySnapshot.forEach((doc) => {
      // doc.data() is never undefined for query doc snapshots
      console.log(doc.id, ' => ', doc.data());
    });
  },
  console.error,
);
return unsubscribe;

