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

function generatePassword($length, $activeCharSets, $allowRepeats = true)
{
  $passwordChars = [];
  $availableChars = [];

  foreach ($activeCharSets as $charSet) {
    $availableChars = array_merge($availableChars, $charSet);
  }

  if (!$allowRepeats && $length > count($availableChars)) {
    return false;
  }

  for ($i = 0; $i < $length; $i++) {
    $randomIndex = random_int(0, count($availableChars) - 1);
    $passwordChars[] = $availableChars[$randomIndex];

    if (!$allowRepeats) {
      array_splice($availableChars, $randomIndex, 1);
    }
  }

  return implode('', $passwordChars);
}
