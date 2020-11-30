<?php
function randomizeString($string)
{
    if (preg_match_all('/(?<={)[^}]*(?=})/', $string, $matches)) {
        $matches = reset($matches);
        foreach ($matches as $i => $match) {
            if (preg_match_all('/(?<=\[)[^\]]*(?=\])/', $match, $sub_matches)) {
                $sub_matches = reset($sub_matches);
                foreach ($sub_matches as $sub_match) {
                    $pieces = explode('|', $sub_match);
                    $count = count($pieces);

                    $random_word = $pieces[rand(0, ($count - 1))];
                    $matches[$i] = str_replace('[' . $sub_match . ']', $random_word, $matches[$i]);
                }
            }

            $pieces = explode('|', $matches[$i]);
            $count = count($pieces);

            $random_word = $pieces[rand(0, ($count - 1))];
            $string = str_replace('{' . $match . '}', $random_word, $string);
        }
    }

    return $string;
}

var_dump(randomizeString('{Please|Just} make this {cool|awesome|random} test sentence {rotate [quickly|fast] and random|spin and be random}.'));
// string(53) "Just make this cool test sentence spin and be random."

var_dump(randomizeString('You can only go two deep. {foo [bar|foo]|abc 123}'));
// string(33) "You can only go two deep. foo foo"
