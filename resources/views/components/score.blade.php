<div id="score-{{ strtolower($player) }}" class="score {{ $player === 'X' ? 'scoreX' : 'scoreO' }}{{ $active ? ' active' : '' }}">
    <img src="/svg/{{ strtolower($player) }}-solid.svg" alt="{{ $player }}">
    <span class="score-content">
        <span class="score-label {{ $player === 'X' ? 'scoreX' : 'scoreO' }}">{{ $player }}:</span>
        <span class="score-value {{ $player === 'X' ? 'scoreX' : 'scoreO' }}">{{ $score }}</span>
    </span>
</div>

