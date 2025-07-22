jQuery(document).ready(function ($) {
  // Provider form handling
  const providerForm = $('#provider-form');
  const providerFormContainer = $('.provider-form-container');

  // Show form
  $('#add-new-provider').on('click', function (e) {
    e.preventDefault();
    $('.provider-form-container').show();
    $('#provider-form')[0].reset();
    $('input[name="provider_id"]').val('');
  });

  // Hide form
  $('#cancel-provider').on('click', function () {
    $('.provider-form-container').hide();
  });

  // Edit provider
  $('.edit-provider').on('click', function (e) {
    e.preventDefault();
    var id = $(this).data('id');

    $.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
        action: 'get_provider',
        provider_id: id,
        nonce: rvAffiliateSearch.nonce
      },
      success: function (response) {
        if (response.success) {
          var provider = response.data;
          $('input[name="provider_id"]').val(provider.id);
          $('input[name="provider_name"]').val(provider.name);
          $('input[name="api_key"]').val(provider.api_key);
          $('input[name="api_secret"]').val(provider.api_secret);
          $('input[name="network_id"]').val(provider.network_id);
          $('input[name="is_active"]').prop('checked', provider.is_active == 1);
          $('.provider-form-container').show();
        }
      }
    });
  });

  // Delete provider
  $('.delete-provider').on('click', function (e) {
    e.preventDefault();
    if (confirm('Are you sure you want to delete this provider?')) {
      var id = $(this).data('id');

      $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
          action: 'delete_provider',
          provider_id: id,
          nonce: rvAffiliateSearch.nonce
        },
        success: function (response) {
          if (response.success) {
            location.reload();
          }
        }
      });
    }
  });

  // Save provider
  $('#provider-form').on('submit', function (e) {
    e.preventDefault();
    var formData = $(this).serialize();

    $.ajax({
      url: ajaxurl,
      type: 'POST',
      data: formData + '&action=save_provider&nonce=' + rvAffiliateSearch.nonce,
      success: function (response) {
        if (response.success) {
          location.reload();
        } else {
          alert(response.data.message || 'Error saving provider');
        }
      },
      error: function () {
        alert('Error saving provider. Please try again.');
      }
    });
  });

  // Settings page
  const settingsForm = $('.rv-settings-form');

  if (settingsForm.length) {
    settingsForm.on('submit', function (e) {
      e.preventDefault();
      const formData = $(this).serialize();

      $.post(ajaxurl, {
        action: 'save_settings',
        nonce: rvAffiliateSearch.nonce,
        settings: formData
      }, function (response) {
        if (response.success) {
          alert('Settings saved successfully!');
        }
      });
    });
  }

  // Test API connection
  $('.test-api-connection').on('click', function (e) {
    e.preventDefault();
    const providerId = $(this).data('provider-id');

    $.post(ajaxurl, {
      action: 'test_api_connection',
      provider_id: providerId,
      nonce: rvAffiliateSearch.nonce
    }, function (response) {
      if (response.success) {
        alert('API connection successful!');
      } else {
        alert('API connection failed: ' + response.data.message);
      }
    });
  });
}); 