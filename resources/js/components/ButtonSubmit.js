export default function ButtonSubmit({ isLoading, children, ...props }) {
  return (
    <button type="submit" className="btn btn-primary button" disabled={isLoading} {...props}>
      {isLoading ? <div className="btn_loader" /> : children}
    </button>
  );
}
