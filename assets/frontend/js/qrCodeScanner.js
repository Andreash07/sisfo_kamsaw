console.log("QR Code Scanner script loaded");

function domReady(fn) {
  if (
    document.readyState === 'complete' ||
    document.readyState === 'interactive'
  ) {
    setTimeout(fn, 1000);
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}

domReady(function () {
  function onScanSuccess(decodeText, decodeResult) {
    if (!decodeText.includes('sisfo-gkpkampungsawah.com')) {
      alert('QR code tidak valid. Silakan coba lagi.');
      return;
    } else {
      const modifiedURL = decodeText.replace('sisfo-gkpkampungsawah.com', 'sisfo.gkpkampungsawah.org');
      window.location.href = modifiedURL;
    }
  }

  let htmlscanner = new Html5QrcodeScanner('my-qr-reader', {
    fps: 10,
    qrbos: 250,
  });
  htmlscanner.render(onScanSuccess);
});
