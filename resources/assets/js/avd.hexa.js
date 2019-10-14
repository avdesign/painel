;(function(window, document){
    var ev = 0;
    var cnvHeight;
    var cnvWidth;
    var mousePos;
    var c;
    var d;
    var ctx;
    var cPix;
    var ctxPix;
    var img;
    var imgHeight;
    var imgWidth;
    var imageData;
    var istat = true;
    var doc = document;
    var oFReader = new FileReader();
    oFReader.onload = function(e) {
        doc.getElementById("slika").src = e.target.result;
    };

    loadCanvasFile = function () {
        var rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
        if (doc.getElementById("uploadCanvas").files.length === 0) {
            return;
        }
        var oFile = doc.getElementById("uploadCanvas").files[0];
        if (!rFilter.test(oFile.type)) {
            msgNotifica(false, 'Você deve selecionar um arquivo de imagem válido!', true, false);
            return;
        }
        oFReader.readAsDataURL(oFile);
    }
    createCanvas = function(cnvWidth,cnvHeight) {
        c = doc.getElementById("myCanvas");
        ctx = c.getContext("2d");
        cPix = doc.getElementById("pixCanvas");
        ctxPix = cPix.getContext("2d");
        ctxPix.mozImageSmoothingEnabled = false;
        ctxPix.webkitImageSmoothingEnabled = false;
        img = doc.getElementById("slika");
        imgHeight = img.height;
        imgWidth = img.width;
        if (imgHeight < cnvHeight && imgWidth < cnvWidth) {
            ctx.mozImageSmoothingEnabled = false;
            ctx.webkitImageSmoothingEnabled = false;
        }
        if ((imgWidth / imgHeight) < 1.56667) {
            cnvWidth = imgWidth / imgHeight * cnvHeight;
        } else {
            cnvHeight = cnvWidth / (imgWidth / imgHeight);
        }
        ctx.clearRect(0, 0, c.width, c.height);
        ctx.drawImage(img, 0, 0, cnvWidth, cnvHeight);
        var onclickListener = function(evt) {
            imageData = ctxPix.getImageData(0, 0, 150, 150);
            var barva = '#' + d2h(imageData.data[45300 + 0]) + d2h(imageData.data[45300 + 1]) + d2h(imageData.data[45300 + 2]);
            doc.getElementById("pixcolor").value = barva;
            doc.getElementById("barvadiv").style.backgroundColor = barva;
        };

        var onmoveListener = function(evt) {
            this.style.cursor="crosshair";
            ev = 1;
            if (istat) {
                mousePos = getMousePos(c, evt);
                drawPix(imgWidth, imgHeight, cPix, ctxPix, img, Math.round(mousePos.x * (imgWidth / cnvWidth)), Math.round(mousePos.y * (imgHeight / cnvHeight)));
            }
        };
        c.addEventListener('mousemove', onmoveListener, false);
        c.addEventListener('mousedown', onclickListener, false);
        var onMiniclickListener = function(evt) {
            mousePos = getMousePos(cPix, evt);
            imageData = ctxPix.getImageData(0, 0, 150, 150);            
            var loc = Math.round(mousePos.y) * 600 + Math.round(mousePos.x) * 4;
            var barva = '#' + d2h(imageData.data[loc + 0]) + d2h(imageData.data[loc + 1]) + d2h(imageData.data[loc + 2]);
            doc.getElementById("pixcolor").value = barva;
            doc.getElementById("pixcolor").select();
            doc.getElementById("barvadiv").style.backgroundColor = barva;
        };
        cPix.addEventListener('mousedown', onMiniclickListener, false);
    }
    drawPix = function(imgWidth, imgHeight, cPix, ctxPix, img, x, y) {
        ctxPix.clearRect(0, 0, cPix.width, cPix.height);
        if (x < 5) x = 5;
        if (y < 5) y = 5;
        if (x > imgWidth - 4) x = imgWidth - 4;
        if (y > imgHeight - 4) y = imgHeight - 4;
        ctxPix.drawImage(img, x - 5, y - 5, 9, 9, 0, 0, cPix.width, cPix.height);
    }
    getMousePos = function(canvas, evt) {
        var rect = canvas.getBoundingClientRect();
        return {
            x: evt.clientX - rect.left,
            y: evt.clientY - rect.top
        };
    }
    d2h = function(d) {
        return ("0" + d.toString(16)).slice(-2).toUpperCase();
    }
})(window, document);  