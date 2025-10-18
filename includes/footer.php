<!-- Footer -->
        <footer class="footer">
            <div class="footer-links">
                <a href="/worksheets/" class="footer-link">Printable Worksheets</a>
                <a href="/blog/" class="footer-link">Math Blog</a>
                <a href="/about/" class="footer-link">About</a>
                <a href="/contact/" class="footer-link">Contact</a>
            </div>
            <p class="footer-copyright">© <?php echo date('Y'); ?> Smarty Pants Math - Making math fun for everyone!</p>
        </footer>
    </div>

    <script src="/assets/js/main.js"></script>
    <?php if (isset($extra_js)): ?>
        <?php foreach ($extra_js as $js_file): ?>
            <script src="<?php echo htmlspecialchars($js_file); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>