-- From http://learnyouahaskell.com/

[1,2,3,4] ++ [9,10,11,12]
"Vari" !! 3  -- 'i'
-- head tail last init length reverse maximum minimum sum product
null [1]  -- False
take 1 [1,2,3]
drop 1 [1,2,3]
4 `elem` [3,4,5,6]  -- True

[1..20]
['a'..'z']
[2,4..20]
[20,19,..,1]
[1..]
cycle [1,2,3]  -- infinite list
repeat 5  -- cycle [5]
replicate 3 [10]  -- [10,10,10]

[x*2 | x <- [1..10], x*2 >= 12]
[ if x < 10 then "BOOM!" else "BANG!" | x <- xs, odd x]
[ x | x <- [10..20], x /= 13, x /= 15, x /= 19]
[ x*y | x <- [2,5,10], y <- [8,10,11]]

fst (8,11)
snd (8,11)
zip [1,2,3,4,5] [5,5,5,5,5]


:t 'a'  -- 'a' :: Char
:t True  -- True :: Boo
:t "HELLO!" -- "HELLO!" :: [Char]
:t (True, 'a')  -- (True, 'a') :: (Bool, Char)
:t 4 == 5  -- 4 == 5 :: Bool

addThree :: Int -> Int -> Int -> Int
addThree x y z = x + y + z

-- Integer is like int but with no limits (and slower)
-- Float Double Char String

:t (==)  -- (==) :: (Eq a) => a -> a -> Bool
:t (>)  -- (>) :: (Ord a) => a -> a -> Bool
show 3  -- "3" (available on Show typeclass)
read "True" || False
read "[1,2,3,4]" ++ [3]
read "5" :: Int

minBound :: Int  -- -2147483648

factorial :: (Integral a) => a -> a
factorial 0 = 1
factorial n = n * factorial (n - 1)

third :: (a, b, c) -> c
third (_, _, z) = z

head' :: [a] -> a
head' [] = error "Can't call head on an empty list"
head' (x:_) = x

tell :: (Show a) => [a] -> String
tell [] = "The list is empty"
tell (x:[]) = "The list has one element: " ++ show x
tell (x:y:[]) = "The list has two elements: " ++ show x ++ " and " ++ show y
tell (x:y:_) = "This list is long. The first two elements are: " ++ show x ++ " and " ++ show y

capital :: String -> String
capital "" = "Empty string"
capital all@(x:xs) = "The first letter of " ++ all ++ " is " ++ [x]

bmiTell :: (RealFloat a) => a -> a -> String
bmiTell weight height
    | bmi <= skinny = "underweight"
    | bmi <= normal = "normal"
    | bmi <= fat    = "fat"
    | otherwise     = "whale"
    where bmi = weight / height ^ 2
          skinny = 18.5
          normal = 25.0
          fat = 30.0

myCompare :: (Ord a) => a -> a -> Ordering
a `myCompare` b
    | a > b     = GT
    | a == b    = EQ
    | otherwise = LT

initials :: String -> String -> String
initials firstname lastname = [f] ++ ". " ++ [l] ++ "."
    where (f:_) = firstname
          (l:_) = lastname

calcBmis :: (RealFloat a) => [(a, a)] -> [a]
calcBmis xs = [bmi w h | (w, h) <- xs]
    where bmi weight height = weight / height ^ 2

calcBmis :: (RealFloat a) => [(a, a)] -> [a]
calcBmis xs = [bmi | (w, h) <- xs, let bmi = w / h ^ 2]

cylinder :: (RealFloat a) => a -> a -> a
cylinder r h =
    let sideArea = 2 * pi * r * h
        topArea = pi * r ^2
    in  sideArea + 2 * topArea

4 * (let a = 9 in a + 1) + 2

describeList :: [a] -> String
describeList xs = "The list is " ++ case xs of [] -> "empty."
                                               [x] -> "a singleton list."
                                               xs -> "a longer list."

quicksort :: (Ord a) => [a] -> [a]
quicksort [] = []
quicksort (x:xs) =
    let smallerSorted = quicksort (filter (<=x) xs)
        biggerSorted = quicksort (filter (>x) xs)
    in  smallerSorted ++ [x] ++ biggerSorted

divideByTen :: (Floating a) => a -> a
divideByTen = (/10)

zipWith' :: (a -> b -> c) -> [a] -> [b] -> [c]
zipWith' _ [] _ = []
zipWith' _ _ [] = []
zipWith' f (x:xs) (y:ys) = f x y : zipWith' f xs ys

flip' :: (a -> b -> c) -> b -> a -> c
flip' f y x = f x y

map :: (a -> b) -> [a] -> [b]
map _ [] = []
map f (x:xs) = f x : map f xs

filter :: (a -> Bool) -> [a] -> [a]
filter _ [] = []
filter p (x:xs)
    | p x       = x : filter p xs
    | otherwise = filter p xs

zipWith (\a b -> (a * 30 + 3) / b) [5,4,3,2,1] [1,2,3,4,5]

sum' :: (Num a) => [a] -> a
sum' xs = foldl (\acc x -> acc + x) 0 xs

sum' :: (Num a) => [a] -> a
sum' = foldl (+) 0

maximum' :: (Ord a) => [a] -> a
maximum' = foldr1 (\x acc -> if x > acc then x else acc)

reverse' :: [a] -> [a]
reverse' = foldl (\acc x -> x : acc) []

product' :: (Num a) => [a] -> a
product' = foldr1 (*)

filter' :: (a -> Bool) -> [a] -> [a]
filter' p = foldr (\x acc -> if p x then x : acc else acc) []

scanl (+) 0 [3,5,2,1]  -- [0,3,8,10,11]
ghci> scanr (+) 0 [3,5,2,1]  -- [11,8,3,1,0]
ghci> scanl1 (\acc x -> if x > acc then x else acc) [3,4,5,3,7,9,2,1]  -- [3,4,5,5,7,9,9,9]
ghci> scanl (flip (:)) [] [3,2,1]  -- [[],[3],[2,3],[1,2,3]]

sum $ map sqrt [1..130]  -- sum (map sqrt [1..130])
-- $ is low precedence and right associative
f $ g $ z x  -- f (g (z x))
map ($ 3) [(4+), (10*), (^2), sqrt] -- [7.0,30.0,9.0,1.7320508075688772]

map (negate . abs)  -- map (\x -> negate (abs x))
(f . g . z) x -- f (g (z x))

sum . replicate 5 . max 6.7 $ 8.9 -- sum (replicate 5 (max 6.7 8.9))
-- or (sum . replicate 5 . max 6.7) 8.9

