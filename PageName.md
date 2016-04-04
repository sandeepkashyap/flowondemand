# Lập Mailling list theo Role #

Giải quyết vấn đề orgchart.


# Details #

**Lập orgchart được tổ chức như sau:
  1. User có nManagerId cho biết cấp trên của người này trong orgchart.
  1. User thuộc nRoleId cho biết user thuộc nhóm người nào: Trưởng phòng, Phó Giám Đốc, Giám đốc...** Thiết lập mailling list theo role
  1. Việc xác định người chịu trách nhiệm xem xét/xử lý item trên workflow có hai cách tùy vào thuộc tính của Node/Slot như sau:
    * Nếu tại Node qui định cụ thể người chịu trách nhiệm thì item sẽ được gửi trực tiếp đến người này.
    * Nếu tại Node chỉ qui định Role xử lý thì system sẽ dựa vào nManagerId của người xử lý ở bước trước để định ra người sẽ xử lý ở bước này.
  1. Sau khi xác định được người xử lý, nếu người này đang nghỉ việc lại có 2 trường hợp
    1. Nếu item trong quá trình tìm người xử lý kế tiếp và người này lại nghỉ thì item này tự động chuyển đến bước xử lý sau của bước này với ghi chú là người này đang nghỉ việc
    1. Với những item đã lỡ nằm trong tầm xử lý của người này thì khi Administrator xác định người này đang nghỉ việc thì system liệt kê tất cả công việc của người nghỉ và Admin chịu trách nhiệm đẩy item này đến bước xử lý tiếp theo.