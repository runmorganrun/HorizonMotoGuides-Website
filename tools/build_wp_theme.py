"""Package the WordPress theme into an installable zip.

Usage: python3 tools/build_wp_theme.py
Output: .tmp/horizon-moto.zip (upload via Appearance → Themes → Add New Theme → Upload Theme)
"""
from pathlib import Path
import zipfile

ROOT = Path(__file__).resolve().parent.parent
THEME = ROOT / "wordpress-theme" / "horizon-moto"
OUT = ROOT / ".tmp" / "horizon-moto.zip"
SKIP = {".DS_Store"}


def main() -> None:
    if not (THEME / "style.css").exists():
        raise SystemExit(f"Theme not found at {THEME}")
    OUT.parent.mkdir(exist_ok=True)
    count = 0
    with zipfile.ZipFile(OUT, "w", zipfile.ZIP_DEFLATED) as zf:
        for path in sorted(THEME.rglob("*")):
            if path.is_file() and path.name not in SKIP:
                # Files must sit inside a top-level "horizon-moto/" folder for WordPress.
                zf.write(path, Path("horizon-moto") / path.relative_to(THEME))
                count += 1
    print(f"Built {OUT} ({count} files, {OUT.stat().st_size // 1024} KB)")


if __name__ == "__main__":
    main()
