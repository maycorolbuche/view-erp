window.open_url = function (path, fields = []) {
    const url = new URL(path, window.location.origin);

    fields.forEach((id) => {
        const field = document.getElementById(id);

        if (!field) return;

        const value = field.value.trim();

        if (value) {
            url.searchParams.set(id, value);
        } else {
            url.searchParams.delete(id);
        }
    });

    window.location.assign(url.href);
};
