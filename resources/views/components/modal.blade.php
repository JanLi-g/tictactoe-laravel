{{-- Modal-Komponente für Benachrichtigungen --}}
<div id="custom-modal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;z-index:9999;">
    <div style="background:#fff;padding:2rem 3rem;border-radius:8px;box-shadow:0 2px 8px #0003;font-size:1.5rem;text-align:center;cursor:pointer;">
        <span id="modal-message">{{ $slot ?? '' }}</span><br><br>
        <button style='margin-top:1rem;padding:0.5rem 1.5rem;font-size:1rem;' onclick="document.getElementById('custom-modal').style.display='none'">OK</button>
    </div>
</div>
