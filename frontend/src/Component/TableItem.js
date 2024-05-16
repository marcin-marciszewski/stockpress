const TableItem = ({ imageItem, index, deleteImage }) => {
  return (
    <div className="divTableRow" key={index}>
      <span className="divTableCell">{index + 1} </span>
      <span className="divTableCell">
        <img
          src={`http://localhost:8080/storage/miniatures/${imageItem.image}`}
          alt=""
          height={50}
          width={90}
        />
      </span>
      <span className="divTableCell">{imageItem.extension} </span>
      <span className="divTableCell">{imageItem.size} MB</span>
      <p className="divTableCell resolution">{imageItem.resolution}</p>
      <span className="divTableCell">{imageItem.uploaderName}</span>
      <span className="divTableCell">
        <button
          onClick={() => deleteImage(imageItem.id)}
          className="btn btn-danger"
        >
          Delete
        </button>
        <a
          className="btn btn-primary ms-1"
          target="_blank"
          rel="noreferrer"
          href={`http://localhost:8080/storage/${imageItem.image}`}
        >
          Download
        </a>
      </span>
    </div>
  );
};

export default TableItem;
