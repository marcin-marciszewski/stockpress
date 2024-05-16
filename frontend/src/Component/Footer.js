const Footer = () => {
  return (
    <footer className="bg-body-dark text-center text-lg-start bg-secondary mt-auto">
      <div className="text-center p-3 text-light ">
        © {new Date().getFullYear()} Copyright
      </div>
    </footer>
  );
};

export default Footer;
