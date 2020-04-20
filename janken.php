<?php
declare(strict_types=1);

const STONE = 0;
const SCISSORS = 1;
const PAPER = 2;

const HANDS = [
  STONE => 'グー',
  SCISSORS => 'チョキ',
  PAPER => 'パー'
];

const DRAW = 0;
const LOSE_PLAYER = 1;
const WIN_PLAYER = 2;

const RESULTS = [
  DRAW => 'あいこです。',
  LOSE_PLAYER => 'あなたの負けです。。',
  WIN_PLAYER => 'あなたの勝ちです！'
];

const YES = 1;
const NO = 2;

const CONTINUES = [
  YES => 'ゲームを続けます！',
  NO => 'ゲームを終了します。'
];

function startJanken() {
  echo '最初はグーじゃんけん。。' . PHP_EOL;
  echo '1:グー 2:チョキ 3:パー :';
  $player_hand = inputPlayerHand();
  $cpu_hand = createCpuHand();
  showResult($player_hand, $cpu_hand);
  echo 'ゲームを続けますか？' . PHP_EOL;
  echo '1:はい 2:いいえ :';
  $continue_key = inputContinueKey();
  showContinueMsg($continue_key);
  $is_continue = shouldContinueJanken($continue_key);
  if ($is_continue) {
    return startJanken();
  }
  return;
}

function showResult(int $player_hand, int $cpu_hand) {
  $result = judgeJanken($player_hand, $cpu_hand);
  echo sprintf('ぽん！ あなた:%s CPU:%s', HANDS[$player_hand], HANDS[$cpu_hand]) . PHP_EOL;
  echo RESULTS[$result] . PHP_EOL;
}

function judgeJanken(int $player_hand, int $cpu_hand) {
  $result = ($player_hand - $cpu_hand + 3) % 3;
  return $result;
}

function inputPlayerHand() {
  $hand = trim(fgets(STDIN));
  $is_valid = validatePlayerHand($hand);
  if (!$is_valid) {
    echo '1〜3のどれかを入力してください:';
    return inputPlayerHand();
  }
  return intval($hand) - 1;
}

function validatePlayerHand(string $hand) {
  if ($hand === strval(STONE + 1) || $hand === strval(SCISSORS + 1) || $hand === strval(PAPER + 1)) {
    return true;
  }
  return false;
}

function createCpuHand() {
  return mt_rand(STONE, PAPER);
}

function showContinueMsg(int $continue_key) {
  echo CONTINUES[$continue_key] . PHP_EOL;
}

function shouldContinueJanken(int $continue_key) {
  if ($continue_key === YES) {
    return true;
  }
  if ($continue_key === NO) {
    return false;
  }
}

function inputContinueKey() {
  $continue_key = trim(fgets(STDIN));
  $is_valid = validateContinueKey($continue_key);
  if (!$is_valid) {
    echo '1, 2のどちらかを入力してください:';
    return inputContinueKey();
  }
  return intval($continue_key);
}

function validateContinueKey(string $continue_key) {
  if ($continue_key === strval(YES) || $continue_key === strval(NO)) {
    return true;
  }
  return false;
}

startJanken();
