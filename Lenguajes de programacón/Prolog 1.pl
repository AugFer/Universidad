% 1.

% animal(X) <- X es un animal
animal(arana).
animal(mono).
animal(gallina).
animal(ballena).
animal(cocodrilo).
animal(mosca).
animal(oso).

% gusta(X, Y) <- a X le gusta Y
gusta(mono, banana).
gusta(oso, pescado).
gusta(arana, hormiga).
gusta(arana, mosca).
gusta(ballena, pescado).
gusta(alumno, logica).
gusta(cocodrilo, X) :- animal(X), cocodrilo \== X.

% a X le gustan otros animales
depredador(X) :- gusta(X, Y), animal(Y).

% Y es un buen regalo para X
regalo(X, Y) :- animal(X), gusta(X, Y).


% - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
% 2.

% progenitor(X, Y) <- X es progenitor de Y
progenitor(nelson, andy).
progenitor(nelson, gimi).
progenitor(norma, andy).
progenitor(norma, gimi).
progenitor(raul, micael).
progenitor(raul, luigi).
progenitor(andy, micael).
progenitor(andy, luigi).
progenitor(gimi, agus).
progenitor(mecha, agus).

% X es abuelo de Y
abuelo(X, Y) :- progenitor(X, Z), progenitor(Z, Y).

% Y es primo de X
primo(X, Y) :- X \== Y, progenitor(A, X), progenitor(B, Y), A \== B, progenitor(Z, A), progenitor(Z, B).

% Y es ancestro de X
ancestro(X, Y) :- progenitor(Y, X).
ancestro(X, Y) :- progenitor(Z, X), ancestro(Z, Y).


% - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
% 3.

% a)
primero([X|_], X).

% b)
pertenece(X, [X|_]).
pertenece(X, [_|Ys]) :- pertenece(X, Ys).

% c)
last(L, U) :- append(_, [U], L).
append([], X, X).
append([H|T], Y, [H|Z]) :- append(T, Y, Z).

last1([X], X).
last1([_|Xs], U) :- last1(Xs, U).

% d)
iesimo(1, [X|_], X). 
iesimo(I, [_|Ls], X) :- Isig is I - 1, iesimo(Isig, Ls, X).

% e)
reverse([], []).
reverse([X|Xs], L1) :- reverse(Xs, Xs_inv), append(Xs_inv, [X], L1).

% f)
maxlista([X], X).
maxlista([X|Xs], X) :- maxlista(Xs, M), M =< X.
maxlista([X|Xs], M) :- maxlista(Xs, M), M > X.

minlista([X], X).
minlista([X|Xs], X) :- minlista(Xs, M), M > X.
minlista([X|Xs], M) :- minlista(Xs, M), M =< X.

% g)
palindromo(L, L1) :- reverse(L, L_inv), append(L, L_inv, L1).

% h) 
% La lista vacia [] no se considera valida
decrece([_]).
decrece([X,Y|Z]) :- X >= Y, decrece([Y|Z]).

% i)
% La lista vacia [] no se considera valida
crece([_]).
crece([X,Y|Z]) :- X =< Y, crece([Y|Z]).
