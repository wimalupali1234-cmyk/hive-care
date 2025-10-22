<footer class="footer">
  <div class="container">
    <p>&copy; <?php echo date('Y'); ?> HIVeCare. All rights reserved.</p>
  </div>
</footer>

<script>
// small helpers for modals used in counsellor views
document.addEventListener('click', function(e){
    if(e.target.matches('.close-modal')){
        document.querySelectorAll('.modal').forEach(function(m){ m.style.display='none'; });
    }
    if(e.target.matches('#scheduleBtn')){
        var modal=document.getElementById('scheduleModal'); if(modal) modal.style.display='flex';
    }
    if(e.target.matches('#editAvailabilityBtn')){
        var modal=document.getElementById('availabilityModal'); if(modal) modal.style.display='flex';
    }
});
</script>
</body>
</html>
