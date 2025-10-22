// Function to load HTML content
async function loadHTML(url, elementId) {
  try {
    const response = await fetch(url);
    const html = await response.text();
    document.getElementById(elementId).innerHTML = html;
  } catch (error) {
    console.error('Error loading HTML:', error);
  }
}

// Load header and footer when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  // Load header
  if (document.getElementById('header-placeholder')) {
    loadHTML('header.html', 'header-placeholder');
  }
  
  // Load footer
  if (document.getElementById('footer-placeholder')) {
    loadHTML('footer.html', 'footer-placeholder');
  }
}); 