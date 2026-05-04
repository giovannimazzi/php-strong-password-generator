<?php

function getCharSets()
{
  return [
    'letters' => array_merge(range('a', 'z'), range('A', 'Z')),
    'numbers' => range(0, 9),
    'symbols' => [
      '!',
      '?',
      '&',
      '%',
      '$',
      '<',
      '>',
      '^',
      '+',
      '-',
      '*',
      '/',
      '(',
      ')',
      '[',
      ']',
      '{',
      '}',
      '@',
      '#',
      '_',
      '=',
    ],
  ];
}

function generatePassword($length, $activeCharSets)
{
  $passwordChars = [];
  $availableChars = [];

  foreach ($activeCharSets as $charSet) {
    $availableChars = array_merge($availableChars, $charSet);
  }

  for ($i = 0; $i < $length; $i++) {
    $randomIndex = random_int(0, count($availableChars) - 1);
    $passwordChars[] = $availableChars[$randomIndex];
  }

  return implode('', $passwordChars);
}
