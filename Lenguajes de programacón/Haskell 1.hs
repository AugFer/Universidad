-- 1
doble :: Int -> Int
doble x = 2 * x

-- 2
cuadrado :: Int -> Int
cuadrado x = x * x

-- 3
sucesor :: Int -> Int
sucesor x = x + 1

-- 4
predecesor :: Int -> Int
predecesor x = x - 1

-- 5
promedio :: (Float, Float) -> Float
promedio (x, y) = (x + y) / 2

-- 6
valorAbsoluto :: Float -> Float
valorAbsoluto x = if (x >= 0) then x
                  else -x

-- 7
signo :: Float -> Int
signo x = if (x < 0) then -1
          else if (x == 0) then 0
               else 1

-- 8
maximo :: (Float, Float) -> Float
maximo (x, y) = if (x > y) then x
                else y

-- 9
max3 :: (Float, Float, Float) -> Float
max3 (x, y, z) = maximo(x, maximo(y, z))

-- 10
max4 :: (Float, Float, Float, Float) -> Float
max4 (w, x, y, z) = maximo(w, maximo(x, maximo(y, z)))

-- 10.1
max4alter :: (Float, Float, Float, Float) -> Float
max4alter (w, x, y, z) = if (w > x && w > y && w > z) then w
                         else if (x > w && x > y && x > z) then x
                              else if (y > w && y > x && y > z) then y
                                   else z

-- 11
minimo :: (Float, Float) -> Float
minimo (x, y) = if (maximo(x, y) == x) then y
                else x

-- 12
orden3 :: (Float, Float, Float) -> String
orden3 (x, y, z) = show (minimo(x, minimo(y, z))) ++ " | " ++
                   show (minimo(x, maximo(y, z))) ++ " | " ++ 
                   show (max3(x, y, z))

-- 13
orden4 :: (Float, Float, Float, Float) -> String
orden4 (w, x, y, z) = show (minimo(w, (minimo(x, minimo(y, z))))) ++ " | " ++
                      show (maximo(w, minimo(x, minimo(y, z))))   ++ " | " ++ 
                      show (maximo(w, minimo(x, maximo(y, z))))   ++ " | " ++ 
                      show (max4(w, x, y, z))

-- 14
fNOT :: Bool -> Bool
fNOT True  = False
fNOT False = True

fOR :: (Bool, Bool) -> Bool
fOR (True, True)   = True
fOR (False, True)  = True
fOR (True, False)  = True
fOR (False, False) = False

fAND :: (Bool, Bool) -> Bool
fAND (True, True)   = True
fAND (False, True)  = False
fAND (True, False)  = False
fAND (False, False) = False

fXOR :: (Bool, Bool) -> Bool
fXOR (True, True)   = False
fXOR (False, True)  = True
fXOR (True, False)  = True
fXOR (False, False) = False

-- 15
par :: Int -> Bool
par 0 = True
par x = impar(x - 1)

impar :: Int -> Bool
impar 0 = False
impar x = par(x - 1)

-- 16
fibonacci :: Int -> Int
fibonacci 0 = 1
fibonacci 1 = 1
fibonacci x = fibonacci(x - 1) + fibonacci(x - 2)

-- 17
factorial :: Int -> Int
factorial 0 = 1
factorial x = x * factorial(x - 1)

-- 18
divisible :: (Int, Int) -> Bool
divisible (x, y) = if (x < y) then if (x == 0) then True 
                                   else False 
                   else divisible(x - y, y)

-- 19
mcd :: (Int, Int) -> Int
mcd (0, 0) = error "La función no esta definida para los valores (0, 0)"
mcd (x, 0) = x
mcd (0, y) = y
mcd (x, y) = valAbs(mcd(y, (x `rem` y)))
             where valAbs n = if (n >= 0) then n
                              else -n

-- 20
mcm :: (Int, Int) -> Int
mcm (0, 0) = 0
mcm (x, 0) = 0
mcm (0, y) = 0
mcm (x, y) = valAbs((x `div` (mcd(x,y))) * y)
             where valAbs n = if (n >= 0) then n
                              else -n

-- 21
bisiesto :: Int -> Bool
bisiesto x = fAND(divisible(x, 4), (fOR(fNOT(divisible(x, 100)), divisible(x, 400))))

-- 22
primo :: Int -> Bool
primo x = pruebaPrimo(x, 2)
          where pruebaPrimo(x, y) = if (x == y) then True
                                 else if (fOR(x < 2, divisible(x, y))) then False
                                      else pruebaPrimo(x, y + 1)

-- 23
cantDivisoresPrimos :: Int -> Int
cantDivisoresPrimos x = pruebaCDP(x, x)
                        where pruebaCDP (x, y) = if (y == 0) then 0
                                                 else if (fAND(divisible(x, y), primo(y))) then 1 + pruebaCDP(x, y - 1)
                                                      else pruebaCDP(x, y - 1)
