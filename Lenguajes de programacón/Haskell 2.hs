-- MANEJO DE LISTAS
-- 1
es_vacia :: [a] -> Bool
es_vacia [] = True
es_vacia (_:_) = False

-- 2
cabeza :: [a] -> a
cabeza [] = error "La lista está vacía"
cabeza (x:_) = x

cola :: [a] -> [a]
cola [] = error "La lista está vacía"
cola (_:xs) = xs

-- 3
long :: [a] -> Int
long [] = 0
long (x:xs) = 1 + long(xs)

suma_lista :: [Int] -> Int
suma_lista [] = 0
suma_lista (x:xs) = x + suma_lista(xs)

member :: (Int, [Int]) -> Bool
member (_, []) = False
member (n, x:xs) = if (n == x) then True 
                   else member(n, xs)

append :: ([a], [a]) -> [a]
append ([], y) = y
append (x, []) = x
append (x:xs, y) = (x:append(xs, y))

tomar :: ([a], Int) -> [a]
tomar ([], _) = []
tomar (_, 0) = []
tomar (x:xs, n) = (x:tomar(xs, n-1))

term :: ([a], Int) -> a
term (x:xs, 0) = x -- 0 para respetar los indices, 1 para un orden de conteo más "natural"
term (x:xs, n) = term(xs,n-1)

rev :: [a] -> [a]
rev [] = []
rev (x:xs) = append(rev(xs), [x])

-- 4
ultimo :: [a] -> a
ultimo [] = error "La lista está vacía"
ultimo (x:[]) = x
ultimo (x:xs) = ultimo(xs)

ultimo' :: [a] -> a
ultimo' x = cabeza(rev(x))

sacar_ultimo :: [a] -> [a]
sacar_ultimo [] = error "La lista está vacía"
sacar_ultimo (x:[]) = []
sacar_ultimo (x:xs) = append([x], sacar_ultimo(xs))

sacar_ultimo' :: [a] -> [a]
sacar_ultimo' x = tomar(x,long(x) - 1)

-- 5
capicua :: Eq a => [a] -> Bool
capicua x = (x == rev(x))

-- 6
flat :: [[a]] -> [a]
flat [] = []
flat [a] = a
flat (x:xs) = append(flat([x]), flat (xs))

-- 7
long_ll :: [[a]] -> Int
long_ll x = long(flat(x))

-- 8
intercalar :: ([[a]], [[a]]) -> [[a]]
intercalar (x, []) = x
intercalar ([], y) = y
intercalar (x:xs, y:ys) = append(append([x], [y]), intercalar(xs,ys))

-- 9
merge :: Ord a => ([a], [a]) -> [a]
merge ([], y) = y
merge (x, []) = x
merge (x:xs, y:ys) = if (x <= y) then append([x], merge(xs, y:ys))
                     else append([y], merge(x:xs, ys))

-- ALTO ORDEN Y ESQUEMAS DE RECURSIÓN
-- 1
-- a
genLista :: (Int, Int, (Int -> Int)) -> [Int]
genLista (0, _, fun) = []
genLista (x, y, fun) = append([y], genLista(x - 1, fun(y), fun))

incremento :: Int -> Int
incremento x = x + 1

-- b
dh :: (Int, Int) -> [Int]
dh (x, y) = if (x < y) then genLista(y - x + 1, x, incremento)
            else error "El primer argumento debe ser menor que el segundo"

-- 2
-- a
--mapo :: ((Int, Int) -> Int) -> [(Int, Int)] -> [Int]
mapo :: ((a, b) -> a) -> [(a, b)] -> [a]
mapo _ [] = []
mapo fun (x:xs) = fun(fst x, snd x) : mapo fun xs

sumMapo :: (Int, Int) -> Int
sumMapo (x, y) = x + y

-- b
--mapo2 :: (Int -> Int -> Int) -> [Int] -> [Int] -> [Int]
mapo2 :: (a -> b -> a) -> [a] -> [b] -> [a]
mapo2 _ [] _ = []
mapo2 _ _ [] = []
mapo2 fun (x:xs) (y:ys) = fun x y : mapo2 fun xs ys

sumMapo2 :: Int -> Int -> Int
sumMapo2 x y = x + y

-- c
sumaMat :: [[Int]] -> [[Int]] -> [[Int]]
sumaMat [] _ = []
sumaMat _ [] = []
sumaMat (x:xs) (y:ys) = mapo2 sumMapo2 x y : sumaMat xs ys
