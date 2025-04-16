$(document).ready(function() {
    const modal = $('#monitorModal');
    const form = $('#monitorForm');
    const submitBtn = $('#submitBtn');

    // Nouveau moniteur
    $('#newMonitorBtn').click(function() {
        $('#modalTitle').text('Nouveau Moniteur');
        form.attr('action', "{{ route('admin.monitors.store') }}");
        $('#_method').val('POST');
        $('#monitorId').val('');
        form.trigger('reset');
        $('#monitorPassword').attr('required', true);
        modal.removeClass('hidden');
    });

    window.handleEditMonitor = function(id) {
        $('#modalTitle').text('Modifier Moniteur');
        form.attr('action', "{{ route('admin.monitors.update', '') }}/" + id);
        $('#_method').val('PUT');
        $('#monitorId').val(id);
        
        // Charger les données du moniteur via AJAX
        $.get("{{ route('admin.monitors.index') }}/" + id + "/edit", function(data) {
            $('#monitorNom').val(data.nom);
            $('#monitorPrenom').val(data.prenom);
            $('#monitorEmail').val(data.email);
            $('#monitorTelephone').val(data.telephone);
            $('#monitorAdresse').val(data.adresse);
            $('#monitorPermisType').val(data.type_permis);
            $('#monitorPassword').val('').removeAttr('required');
        });
        
        modal.removeClass('hidden');
    };

    window.handleDeleteMonitor = function(id) {
        if (!confirm('Voulez-vous vraiment supprimer ce moniteur ?')) return;
        
        $.ajax({
            url: "{{ route('admin.monitors.destroy', '') }}/" + id,
            method: 'POST',
            data: { 
                _method: 'DELETE', 
                _token: "{{ csrf_token() }}" 
            },
            success: function() {
                window.location.reload();
            },
            error: function(xhr) {
                alert('Erreur lors de la suppression: ' + xhr.responseJSON?.message);
            }
        });
    };

    $('#cancelBtn').click(function() {
        modal.addClass('hidden');
    });
});