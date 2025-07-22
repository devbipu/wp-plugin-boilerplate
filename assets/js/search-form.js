jQuery(document).ready(function ($) {
  const form = $('#rv-search-form');

  // Set minimum date for date inputs
  const today = new Date().toISOString().split('T')[0];
  $('#start_date, #end_date').attr('min', today);

  // Validate end date is after start date
  $('#start_date').on('change', function () {
    const startDate = $(this).val();
    $('#end_date').attr('min', startDate);

    // If end date is before start date, update it
    if ($('#end_date').val() && $('#end_date').val() < startDate) {
      $('#end_date').val(startDate);
    }
  });

  // Form submission
  form.on('submit', function (e) {
    e.preventDefault();

    const location = $('#location').val().trim();
    const startDate = $('#start_date').val();
    const endDate = $('#end_date').val();

    if (!location || !startDate || !endDate) {
      alert('Please fill in all fields');
      return;
    }

    // Redirect to results page with search parameters
    const resultsPageUrl = rvAffiliateSearch.resultsPageUrl;
    const queryParams = new URLSearchParams({
      location: location,
      start_date: startDate,
      end_date: endDate
    });

    window.location.href = `${resultsPageUrl}?${queryParams.toString()}`;
  });

  // Location autocomplete
  if (typeof google !== 'undefined' && google.maps && google.maps.places) {
    const locationInput = document.getElementById('location');
    const autocomplete = new google.maps.places.Autocomplete(locationInput, {
      types: ['(cities)'],
      fields: ['formatted_address', 'geometry', 'name'],
    });

    autocomplete.addListener('place_changed', function () {
      const place = autocomplete.getPlace();
      if (place.geometry) {
        locationInput.value = place.formatted_address;
      }
    });
  }
}); 