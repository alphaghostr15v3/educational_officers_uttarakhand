import os

file_path = r'c:\xampp\htdocs\EducationalMinisterialOfficersUttarakhand\public\css\public.css'
with open(file_path, 'r', encoding='utf-8', errors='ignore') as f:
    lines = f.readlines()

# We want to keep up to line 839 (index 838) but only the first character '}'
# Or better, just keep lines 0 to 838 (the last good brace)
good_lines = lines[:839]
# Check if the last line is corrupted
if '@ m e d i a' in good_lines[-1]:
    # Truncate to 838 lines
    good_lines = lines[:838]
    # Ensure it ends with a closing brace
    if not good_lines[-1].strip() == '}':
        good_lines.append('\n}\n')

with open(file_path, 'w', encoding='utf-8') as f:
    f.writelines(good_lines)

print("File cleaned up successfully.")
