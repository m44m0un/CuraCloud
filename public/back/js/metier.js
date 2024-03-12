// Function to update the URL and store selected values in localStorage
function updateUrlAndStoreValues() {
    // Get the selected values from the dropdowns
    var roleValue = document.getElementById('UserRole').value;
    var statusValue = document.getElementById('FilterTransaction').value;

    // Store the selected values in localStorage
    localStorage.setItem('selectedRole', roleValue);
    localStorage.setItem('selectedStatus', statusValue);

    // Construct and update the URL
    updateUrl();
  }

  // Function to update the URL based on stored values
  function updateUrl() {
    // Get the stored values from localStorage
    var storedRole = localStorage.getItem('selectedRole') || '';
    var storedStatus = localStorage.getItem('selectedStatus') || '';

    // Set the selected values in the dropdowns
    document.getElementById('UserRole').value = storedRole;
    document.getElementById('FilterTransaction').value = storedStatus;

    // Construct the new URL with the stored values
    var newUrl = window.location.href.split('?')[0]; // Get the current URL without parameters

    // Add parameters to the URL only if values are selected
    if (storedRole !== '') {
      newUrl += '?role=' + encodeURIComponent(storedRole);
    }

    if (storedStatus !== '') {
      newUrl += (storedRole !== '' ? '&' : '?') + 'status=' + encodeURIComponent(storedStatus);
    }

    // Check if the constructed URL is different from the current URL
    if (newUrl !== window.location.href) {
      // Redirect to the new URL only if it's different
      window.location.href = newUrl;
    }
  }

  // Attach the updateUrlAndStoreValues function to the change event of the dropdowns
  document.getElementById('UserRole').addEventListener('change', updateUrlAndStoreValues);
  document.getElementById('FilterTransaction').addEventListener('change', updateUrlAndStoreValues);

  // Call updateUrl on page load
  window.onload = updateUrl;