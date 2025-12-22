window.akunSearch = function () {
    return {
        search: "",

        init() {
            // optional
        },

        fetchData() {
            const params = new URLSearchParams({
                search: this.search,
            });

            fetch(`${window.location.pathname}?${params.toString()}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((res) => res.text())
                .then((html) => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    const table = doc.querySelector("#akun-table");

                    if (table) {
                        document.querySelector("#akun-table").innerHTML =
                            table.innerHTML;
                    }
                });
        },
    };
};
