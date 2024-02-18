## Laravel Weather Command

### Komandani ishlatish

```bash
php artisan weather {provider} {city} --telegram={chat_id}
```

### Ma'lumotlar

- **provider**: Havoning ma'lumotlarini olish uchun provayder. Quyidagi variantlardan biri bo'lishi kerak: `open-weather`, `open-weather-map`.
- **city**: Havoning ma'lumotlarini olish uchun shahar nomi.
- **--telegram=**: Havoning ma'lumotlarini telegram chatga yuborish. Agar kiritilmasa natija console chiqariladi

### Namuna

```bash
php artisan weather open-weather Tashkent
```

```bash
php artisan weather open-weather Tashkent --telegram=12345678
```

### Testlash

```bash
php artisan test
```
