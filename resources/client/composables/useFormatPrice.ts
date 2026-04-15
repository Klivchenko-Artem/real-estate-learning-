export function useFormatPrice() {
    const formatPrice = (price: number): string => {
        if (price >= 1_000_000)
            return (price / 1_000_000).toFixed(1).replace(".0", "") + " млн ₽";
        return price.toLocaleString("ru") + " ₽";
    };

    return { formatPrice };
}
